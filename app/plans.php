<?php
/**
 * Membership plans (part of the main Toutify subscription) and
 * done-for-you managed packages. Limits are per business per month.
 */
const PLANS = [
    'starter' => [
        'name' => 'Starter', 'price' => 0, 'verb' => 'Create',
        'tagline' => 'Free AI content creation for business owners getting started.',
        'generations' => 5, 'scheduling' => false, 'scheduled_posts' => 0,
        'images' => 0, 'social_accounts' => 0, 'campaign_channels' => 3,
    ],
    'pro' => [
        'name' => 'Pro', 'price' => 19, 'verb' => 'Schedule',
        'tagline' => 'Consistent content and social publishing with less work.',
        'generations' => 40, 'scheduling' => true, 'scheduled_posts' => 30,
        'images' => 10, 'social_accounts' => 3, 'campaign_channels' => 8,
    ],
    'premium' => [
        'name' => 'Premium', 'price' => 49, 'verb' => 'Automate',
        'tagline' => 'A complete AI-powered content and promotion system.',
        'generations' => 150, 'scheduling' => true, 'scheduled_posts' => 150,
        'images' => 40, 'social_accounts' => 7, 'campaign_channels' => 8,
    ],
];

/** Feature comparison table shown on the pricing page: [feature, starter, pro, premium] */
const PLAN_FEATURES = [
    ['AI content generations / month', '5', '40', '150'],
    ['Blog and article writer', 'Basic', 'Full', 'Full'],
    ['Social media caption writer', true, true, true],
    ['One idea → full campaign builder', 'Up to 3 channels', 'All 8 channels', 'All 8 channels'],
    ['Business-branded images / month', false, '10', '40'],
    ['Connected social accounts', false, '3', '7'],
    ['Scheduled posts / month', false, '30', '150'],
    ['Content calendar', 'Basic', 'Full', 'Advanced'],
    ['Auto-publish to supported networks', false, true, true],
    ['Turn articles into social posts', false, true, true],
    ['AI monthly content planner', false, false, true],
    ['Automatic content recycling', false, false, true],
    ['Directory content distribution', 'Manual', 'Limited', 'Advanced'],
    ['Content performance dashboard', 'Basic', 'Standard', 'Advanced'],
];

const PACKAGES = [
    'starter' => [
        'name' => 'Content Starter', 'price' => 299,
        'for' => 'For a solo business owner who wants someone else to handle basic marketing.',
        'includes' => ['4 social campaigns / month', 'Adapted for up to 3 networks', '1 website article', 'Monthly report', 'Premium membership included'],
    ],
    'growth' => [
        'name' => 'Content Growth', 'price' => 749, 'featured' => true,
        'for' => 'For companies that want consistent weekly visibility without managing their own content.',
        'includes' => ['8 social campaigns / month', 'Adapted for up to 5 networks', '4 website articles', 'Promotional offers', 'Scheduling and reporting', 'Premium membership included'],
    ],
    'dominator' => [
        'name' => 'Content Dominator', 'price' => 999,
        'for' => 'For established businesses looking for a more active online marketing presence.',
        'includes' => ['20 social campaigns / month', 'Adapted for up to 6 networks', '4 website articles', 'Monthly campaign planning', 'Content repurposing', 'Reporting', 'Premium membership included'],
    ],
];

/** Business goals the owner picks instead of writing prompts */
const GOALS = [
    'calls'    => 'Get more calls',
    'special'  => 'Promote a special',
    'service'  => 'Announce a new service',
    'job'      => 'Share a completed job',
    'active'   => 'Keep my business active',
];

/** Destinations for the campaign builder, with writing guidance for the AI */
const CHANNELS = [
    'article'         => ['label' => 'Website article',        'icon' => '📝', 'guide' => 'A helpful 400-600 word website/blog article with a clear H1-style title, short sections, local relevance and a call to action. Plain text with blank lines between paragraphs; section headings on their own line.'],
    'facebook'        => ['label' => 'Facebook post',          'icon' => '👍', 'guide' => 'A conversational Facebook Page post, 60-120 words, friendly, with a clear call to action and phone number. 0-2 emojis.'],
    'instagram'       => ['label' => 'Instagram caption',      'icon' => '📸', 'guide' => 'An Instagram caption, 40-90 words, strong first line, a call to action, then 5-10 relevant local hashtags on the last line.'],
    'pinterest'       => ['label' => 'Pinterest pin',          'icon' => '📌', 'guide' => 'A Pinterest pin: the title is the pin title (max 100 chars); the body is a keyword-rich pin description, 2-3 sentences.'],
    'google_business' => ['label' => 'Google Business update', 'icon' => '📍', 'guide' => 'A Google Business Profile update, under 1,000 characters (aim for 80-150 words), factual, no hashtags, with a call to action such as "Call now".'],
    'directory'       => ['label' => 'Directory promotion',    'icon' => '📇', 'guide' => 'A promotion for Toutify directory listings (SearchMonster storefront, MonsterList, state directories): concise, factual, 50-100 words, including service area and contact details. Write it to be useful to someone browsing a local directory, not a copy of the article.'],
    'email'           => ['label' => 'Email promotion',        'icon' => '✉️', 'guide' => 'A short customer email: the title is the subject line; the body starts with a preview line, then a greeting, 2-3 short paragraphs and a single call to action.'],
    'video_script'    => ['label' => 'Video script',           'icon' => '🎬', 'guide' => 'A 30-45 second vertical video script (Reels/TikTok/Shorts) with HOOK, SCENES (numbered, each with what to film and what to say) and CALL TO ACTION sections.'],
];

function plan_of(array $user): array
{
    return PLANS[$user['plan']] ?? PLANS['starter'];
}
