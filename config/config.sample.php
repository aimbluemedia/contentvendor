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

    // The first account registered with this email becomes an admin (team dashboard).
    'admin_email' => 'you@example.com',

    // Password reset emails are sent from this address. On Hostinger use an address on your own domain
    // (create it in hPanel > Emails), e.g. no-reply@contentvendor.com. Empty = no-reply@<your domain>.
    'mail_from'      => '',
    'mail_from_name' => 'ContentVendor',

    // Where "Upgrade" buttons go (your Toutify subscription page). Empty = done-for-you contact form.
    'upgrade_url' => '',
    'timezone'    => 'America/New_York',
];
