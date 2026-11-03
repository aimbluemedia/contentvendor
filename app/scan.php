<?php
/**
 * Lightweight public website check for the homepage calculator.
 * Fetches one page of a business website and reports simple visibility
 * signals. Guards against SSRF: only http(s) on ports 80/443, the host must
 * resolve to public IPv4 addresses only, the connection is pinned to the
 * checked IP, redirects are re-validated, and size and time are capped.
 */

class ScanException extends RuntimeException {}

function scan_normalize_url(string $input): string
{
    $input = trim($input);
    if ($input === '' || strlen($input) > 300) {
        throw new ScanException('Enter your website address, like yourbusiness.com.');
    }
    if (!preg_match('~^https?://~i', $input)) {
        $input = 'https://' . $input;
    }
    $parts = parse_url($input);
    if (!$parts || empty($parts['host']) || isset($parts['user']) || isset($parts['pass'])) {
        throw new ScanException('That doesn\'t look like a website address.');
    }
    $host = strtolower($parts['host']);
    if (!preg_match('/^(?=.{1,253}$)([a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,63}$/', $host)) {
        throw new ScanException('That doesn\'t look like a website address.');
    }
    $port = $parts['port'] ?? null;
    if ($port !== null && !in_array((int) $port, [80, 443], true)) {
        throw new ScanException('That doesn\'t look like a website address.');
    }
    $path = $parts['path'] ?? '/';
    return strtolower($parts['scheme']) . '://' . $host . ($port ? ':' . $port : '') . ($path === '' ? '/' : $path);
}

function scan_is_public_ipv4(string $ip): bool
{
    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        return false;
    }
    $n = ip2long($ip);
    // Extra special-use ranges PHP's filter allows: CGNAT, benchmarking, IETF protocol assignments
    foreach (['100.64.0.0/10', '198.18.0.0/15', '192.0.0.0/24'] as $cidr) {
        [$net, $bits] = explode('/', $cidr);
        $mask = -1 << (32 - (int) $bits);
        if (($n & $mask) === (ip2long($net) & $mask)) {
            return false;
        }
    }
    return true;
}

/** Resolve a host to a single public IPv4 address, or fail */
function scan_public_ip(string $host): string
{
    $ips = @gethostbynamel($host);
    if (!$ips) {
        throw new ScanException('We couldn\'t find that website. Check the address and try again.');
    }
    foreach ($ips as $ip) {
        if (!scan_is_public_ipv4($ip)) {
            throw new ScanException('We can only check public websites.');
        }
    }
    return $ips[0];
}

function scan_fetch(string $url): array
{
    $maxBytes = 1500000;
    for ($hop = 0; $hop < 4; $hop++) {
        $p = parse_url($url);
        $scheme = $p['scheme'];
        $host = strtolower($p['host']);
        $port = (int) ($p['port'] ?? ($scheme === 'https' ? 443 : 80));
        $ip = scan_public_ip($host);

        $body = '';
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RESOLVE        => ["{$host}:{$port}:{$ip}"],
            CURLOPT_PROXY          => '',
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_PROTOCOLS      => CURLPROTO_HTTP | CURLPROTO_HTTPS,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT        => 9,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; ContentVendorCheck/1.0)',
            CURLOPT_HTTPHEADER     => ['Accept: text/html,application/xhtml+xml'],
            CURLOPT_HEADER         => false,
            CURLOPT_WRITEFUNCTION  => function ($ch, $chunk) use (&$body, $maxBytes) {
                $body .= $chunk;
                return strlen($body) > $maxBytes ? 0 : strlen($chunk);
            },
        ]);
        $ok = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $redirect = (string) curl_getinfo($ch, CURLINFO_REDIRECT_URL);
        $errno = curl_errno($ch);
        curl_close($ch);

        if ($ok === false && $errno !== CURLE_WRITE_ERROR) {
            if ($scheme === 'https' && $hop === 0) {
                $url = 'http://' . substr($url, 8); // some small-business sites still lack SSL
                continue;
            }
            throw new ScanException('We couldn\'t reach that website right now.');
        }
        if ($status >= 300 && $status < 400 && $redirect !== '') {
            $url = scan_normalize_url($redirect);
            continue;
        }
        if ($status >= 400) {
            throw new ScanException('That website returned an error, so we couldn\'t check it.');
        }
        return ['url' => $url, 'html' => $body];
    }
    throw new ScanException('That website redirects too many times.');
}

/** Pull simple visibility signals out of a page's HTML */
function scan_analyze(string $url, string $html): array
{
    $find = fn(string $re) => (bool) preg_match($re, $html);
    $title = '';
    if (preg_match('~<meta[^>]+property=["\']og:site_name["\'][^>]*content=["\']([^"\']{2,120})~i', $html, $m)) {
        $title = $m[1];
    } elseif (preg_match('~<title[^>]*>(.*?)</title>~is', $html, $m)) {
        $title = preg_split('/\s+[|\-–—:]\s+/u', trim($m[1]))[0] ?? '';
    }
    $title = trim(html_entity_decode(strip_tags($title), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

    return [
        'domain'      => preg_replace('/^www\./', '', (string) parse_url($url, PHP_URL_HOST)),
        'name'        => mb_substr($title, 0, 80),
        'https'       => str_starts_with($url, 'https://'),
        'description' => $find('~<meta[^>]+name=["\']description["\'][^>]*content=["\'][^"\']{20,}~i'),
        'blog'        => $find('~href=["\'][^"\']*/(blog|news|articles|tips|resources)(/|["\'?#])~i'),
        'facebook'    => $find('~href=["\'][^"\']*facebook\.com/(?!sharer|share\.php|dialog|plugins)[^"\']+~i'),
        'instagram'   => $find('~href=["\'][^"\']*instagram\.com/(?!share)[^"\']+~i'),
        'google'      => $find('~href=["\'][^"\']*(g\.page/|maps\.app\.goo\.gl|google\.com/maps|business\.google\.com|g\.co/kgs|search\.google\.com/local)~i'),
        'video'       => $find('~href=["\'][^"\']*(youtube\.com/(@|c/|channel/|user/)|tiktok\.com/@)~i'),
        'phone'       => $find('~href=["\']tel:~i'),
    ];
}
