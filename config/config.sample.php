<?php
/**
 * ContentVendor configuration.
 * Copy this file to config/config.php on the server and fill in real values.
 * config/config.php is git-ignored so secrets never reach GitHub.
 */
return [
    'app_name' => 'ContentVendor',
    'app_url'  => 'https://contentvendor.example.com', // no trailing slash
    'debug'    => false,

    // Hostinger: hPanel > Databases > MySQL Databases
    'db' => [
        'dsn'      => 'mysql:host=localhost;dbname=u123456789_contentvendor;charset=utf8mb4',
        'user'     => 'u123456789_cvuser',
        'password' => 'change-me',
    ],

    // Claude API key from https://platform.claude.com - leave empty to run in demo mode
    // (demo mode produces template drafts so the site works before you add a key).
    'anthropic' => [
        'api_key' => '',
        'model'   => 'claude-opus-5-5',
        'base_url' => 'https://api.anthropic.com',
        'effort'  => 'medium', // low | medium | high
        'fallbacks' => true,   // re-run declined requests on Anthropic's recommended fallback model
    ],

    // Toutify sign-in (OpenID Connect). Prefer environment variables TOUTIFY_ISSUER, TOUTIFY_CLIENT_ID,
    // TOUTIFY_CLIENT_SECRET and TOUTIFY_WEBHOOK_SECRET; these values are used only when those aren't set.
    'toutify' => [
        'issuer'         => 'https://toutify.com',
        'client_id'      => 'contentvendor',
        'client_secret'  => '',   // from Toutify (Superadmin > Sites > ContentVendor)
        'webhook_secret' => '',   // from Toutify (Superadmin > Sites > ContentVendor)
        // Toutify member IDs (the 26-character "sub") that get the ContentVendor super admin role
        'admin_subs'     => [],
        // Optional: map Toutify tier values to ContentVendor plans (free/pro/premium are mapped already)
        'tier_map'       => [],
    ],

    // Where "Upgrade" buttons go (your Toutify subscription page). Empty = done-for-you contact form.
    'upgrade_url' => '',
    // Footer legal links. Leave empty to use ContentVendor's own /privacy and /terms pages.
    'privacy_url' => '',
    'terms_url'   => '',

    // Details shown on the Privacy Policy and Terms of Service pages
    'legal' => [
        'company'       => 'Global Media Inc',   // legal business name
        'email'         => '',          // contact email for privacy and legal questions
        'address'       => '',          // mailing address (optional)
        'governing_law' => '',          // e.g. "the State of Arizona"
        'updated'       => 'November 13, 2026',
    ],
    'timezone'    => 'America/New_York',
];
