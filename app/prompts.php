<?php
/**
 * Creator prompts: ready-to-paste prompts members use in their favourite image,
 * video or AI tools (Canva, ChatGPT, Gemini, Adobe Express, CapCut...).
 * Built from the draft and the business profile; no outside service is called.
 */

/** Image format for each channel: [ratio, where it's used] */
const PROMPT_FORMATS = [
    'facebook'        => ['1:1 square (1080×1080)', 'a Facebook post'],
    'instagram'       => ['4:5 portrait (1080×1350)', 'an Instagram post'],
    'pinterest'       => ['2:3 tall (1000×1500)', 'a Pinterest pin'],
    'google_business' => ['4:3 landscape (1200×900)', 'a Google Business Profile update'],
    'article'         => ['16:9 wide (1600×900)', 'a website blog header'],
    'email'           => ['3:1 wide banner (1200×400)', 'an email header'],
    'reddit'          => ['4:3 landscape (1200×900)', 'a Reddit post'],
    'directory'       => ['4:3 landscape (1200×900)', 'a business directory listing'],
    'video_script'    => ['9:16 vertical (1080×1920)', 'a TikTok, Reels or Shorts cover'],
];

function prompt_clean(string $s, int $max = 0): string
{
    $s = trim(preg_replace('/\s+/u', ' ', strip_tags($s)));
    return $max && mb_strlen($s) > $max ? rtrim(mb_substr($s, 0, $max - 1)) . '…' : $s;
}

/** The headline to put on the image: the title, or the first sentence of the body */
function prompt_headline(array $item): string
{
    $t = prompt_clean((string) $item['title']);
    if ($t === '') {
        $t = prompt_clean(preg_split('/(?<=[.!?])\s/u', (string) $item['body'])[0] ?? '');
    }
    return prompt_clean($t, 70);
}

/** List of [label, hint, prompt] for one content item */
function creator_prompts(array $item, array $p): array
{
    $name = prompt_clean($p['business_name'] ?: 'the business');
    $what = prompt_clean($p['industry'] ?: (string) $p['services'], 120);
    // lower-case the first letter unless it's an acronym ("Artificial turf" -> "artificial turf", "HVAC" stays)
    if (preg_match('/^\p{Lu}\p{Ll}/u', $what)) $what = mb_strtolower(mb_substr($what, 0, 1)) . mb_substr($what, 1);
    $where = prompt_clean((string) $p['location']);
    $phone = prompt_clean((string) $p['phone']);
    $voice = prompt_clean($p['brand_voice'] ?: 'friendly');
    $who = prompt_clean((string) $p['audience'], 120);
    [$ratio, $use] = PROMPT_FORMATS[$item['channel']] ?? PROMPT_FORMATS['facebook'];
    $headline = prompt_headline($item);
    $topic = prompt_clean((string) $item['body'], 300);

    $image = "Create a professional, eye-catching image for {$use} for {$name}, a local {$what} business"
        . ($where ? " in {$where}" : '') . ".\n\n"
        . "Main message (large, bold, easy to read): \"{$headline}\"\n"
        . "Small text: \"{$name}\"" . ($phone ? " · {$phone}" : '') . "\n\n"
        . "What the post is about: {$topic}\n\n"
        . "Style: realistic photo of real {$what} work" . ($where ? " in a {$where} setting" : '') . ", bright natural light, clean modern layout, high contrast text, {$voice} feel"
        . ($who ? ", appealing to {$who}" : '') . ".\n"
        . "Format: {$ratio}. Keep all text spelled exactly as written. No other logos, no watermarks, no fake reviews or prices that aren't in the message.";

    $prompts = [['Image prompt', 'Paste into Canva (Magic Media), ChatGPT, Gemini, Adobe Express or your favourite image creator.', $image]];

    if ($item['channel'] === 'video_script') {
        $prompts[] = ['Video prompt', 'Paste into CapCut, Canva video, or any AI video creator. Or use it as your shot list.',
            "Create a 30–45 second vertical (9:16) video for TikTok, Instagram Reels and YouTube Shorts for {$name}, a local {$what} business"
            . ($where ? " in {$where}" : '') . ".\n\n"
            . "Follow this script exactly (hook, scenes, call to action):\n" . trim((string) $item['body']) . "\n\n"
            . "Style: authentic and local, real job footage, fast cuts every 2–3 seconds, bold on-screen captions for every line, upbeat background music at low volume. "
            . "End on a clear call to action with \"{$name}\"" . ($phone ? " and {$phone}" : '') . " on screen."];
    } else {
        $prompts[] = ['Short video prompt', 'Turn this post into a quick vertical video with CapCut, Canva video or any AI video creator.',
            "Create a 15–20 second vertical (9:16) video for {$name}, a local {$what} business" . ($where ? " in {$where}" : '') . ".\n\n"
            . "Hook on screen in the first 2 seconds: \"{$headline}\"\n"
            . "Then show 3–4 quick clips of real {$what} work with bold captions summarising: {$topic}\n"
            . "End screen: \"{$name}\"" . ($phone ? " · {$phone}" : '') . " with a clear call to action.\n"
            . "Style: authentic, bright, fast-paced, {$voice} tone, captions on every scene."];
    }

    $prompts[] = ['Variations prompt', 'Paste into ChatGPT, Gemini or Claude to get fresh versions of this post.',
        "You are a social media writer for {$name}, a local {$what} business" . ($where ? " in {$where}" : '') . ". Brand voice: {$voice}.\n\n"
        . "Here is a post we wrote:\n\"\"\"\n" . trim((string) $item['title'] . "\n\n" . $item['body']) . "\n\"\"\"\n\n"
        . "Write 3 fresh variations for {$use} with different opening hooks. Keep the same facts and offer, don't invent prices or claims, and end each with a clear call to action."];

    return $prompts;
}
