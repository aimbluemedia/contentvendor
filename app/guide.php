<?php
/** Posting Guide: step-by-step instructions for each planner platform (keys match PLAN_PLATFORMS) */
const POSTING_GUIDE = [
    'facebook' => [
        'title' => 'Facebook', 'where' => 'Your Facebook business Page (app or facebook.com)',
        'format' => 'Text post with 1–4 photos, or a short video',
        'best' => 'Weekdays, 8–10am or around lunch',
        'steps' => [
            'Open Facebook and switch to your business Page (tap your profile picture and choose the Page).',
            'Tap "What\'s on your mind?" or "Create post".',
            'In ContentVendor, open the task and tap Copy, then paste the post into Facebook.',
            'Tap Photo/video and add a real photo of your work. Photos get far more reach than text alone.',
            'Tap Post. To post later, use the scheduling option or Meta Business Suite > Planner.',
        ],
        'tips' => ['Reply to every comment within a day.', 'Real job photos beat stock images.', 'Put your phone number or offer in the first line.'],
    ],
    'instagram' => [
        'title' => 'Instagram', 'where' => 'The Instagram app on your phone (business or creator account)',
        'format' => 'Square (1:1) or portrait (4:5) photo, carousel or Reel',
        'best' => 'Weekdays, 11am–1pm or 7–9pm',
        'steps' => [
            'Copy the caption from your ContentVendor task, then open Instagram.',
            'Tap + (Create) and choose Post.',
            'Pick one photo, or several for a carousel. Crop to square or portrait, then tap Next.',
            'Add a filter if you like and tap Next.',
            'Paste the caption with its hashtags, tap Add location and choose your city.',
            'Tap Share.',
        ],
        'tips' => ['Use a business or creator account to see your insights.', 'Before-and-after carousels work very well.', 'Share the post to your Story too.'],
    ],
    'google_business' => [
        'title' => 'Google Business', 'where' => 'Your Google Business Profile (Google Search or Maps)',
        'format' => 'Update, offer or event with one photo and a button',
        'best' => 'Once or twice a week, any time',
        'steps' => [
            'Sign in to the Google account that manages your business.',
            'Search Google for your business name. Your profile tools appear at the top.',
            'Click Add update (or Promote > Add update, Add offer or Add event).',
            'Paste the text from your ContentVendor task (up to 1,500 characters).',
            'Add a photo and a button such as Call now or Learn more.',
            'Click Post. It shows on your profile in Google Search and Maps.',
        ],
        'tips' => ['Offers show a badge on your listing, so use them for specials.', 'Mention your service and city by name.', 'Post regularly: active profiles look trustworthy.'],
    ],
    'tiktok' => [
        'title' => 'TikTok', 'where' => 'The TikTok app on your phone',
        'format' => 'Vertical video (9:16), 15–60 seconds',
        'best' => 'Evenings, 6–9pm',
        'steps' => [
            'Read your ContentVendor video script. It lists the hook, the shots and what to say.',
            'Open TikTok and tap +.',
            'Record the video holding your phone upright, or tap Upload to use a clip you filmed.',
            'Add on-screen text for the hook and turn on auto captions.',
            'Tap Next, paste the caption and hashtags from your task, then tap Post.',
        ],
        'tips' => ['Hook viewers in the first 2 seconds.', 'Film real work, not polished ads.', 'Popular sounds at low volume help reach.'],
    ],
    'youtube' => [
        'title' => 'YouTube Shorts', 'where' => 'The YouTube app on your phone',
        'format' => 'Vertical video (9:16), under 60 seconds works best',
        'best' => 'Afternoons and evenings',
        'steps' => [
            'Use the video script from your ContentVendor task as your shot list.',
            'Open YouTube, tap + and choose Create a Short.',
            'Record vertically, or tap the gallery icon to upload a clip.',
            'Add text and music if you like, then tap Next.',
            'Paste a short title from your task, then tap Upload Short.',
        ],
        'tips' => ['Put your city and service in the title.', 'The same video can go on TikTok and Shorts.', 'End with a clear call: "Call us for a free quote".'],
    ],
    'pinterest' => [
        'title' => 'Pinterest', 'where' => 'pinterest.com or the app (business account)',
        'format' => 'Tall image (2:3, e.g. 1000×1500) that links to your website',
        'best' => 'Evenings and weekends',
        'steps' => [
            'Open Pinterest and click Create > Create Pin.',
            'Upload a tall photo of your work.',
            'Paste the title and description from your ContentVendor task.',
            'Add your website link so people can click through.',
            'Choose a board (for example "Backyard ideas") and click Publish, or schedule it.',
        ],
        'tips' => ['Pins keep sending visitors for months.', 'Use words people search for, like "small backyard ideas".', 'Make boards for each service you offer.'],
    ],
    'reddit' => [
        'title' => 'Reddit', 'where' => 'Local communities such as r/YourCity (reddit.com or the app)',
        'format' => 'Helpful text post or comment, not an ad',
        'best' => 'Mornings, when locals are browsing',
        'steps' => [
            'Find your local communities: search Reddit for your city or area.',
            'Read each community\'s rules first. Many ban self-promotion.',
            'Click Create Post and choose the community.',
            'Paste the title and helpful advice from your ContentVendor task.',
            'Click Post, then answer questions in the comments.',
        ],
        'tips' => ['Be helpful first. Mention your business only where the rules allow.', 'Answering questions in comments builds trust.', 'Never post the same thing to many communities.'],
    ],
    'article' => [
        'title' => 'Website blog', 'where' => 'Your website\'s editor (WordPress, Wix, Squarespace…)',
        'format' => 'Article with headings and at least one photo',
        'best' => 'Any day. Consistency matters more than timing',
        'steps' => [
            'Sign in to your website editor (in WordPress: Posts > Add New).',
            'Paste the title and the article from your ContentVendor task.',
            'Check the headings are formatted as headings, not bold text.',
            'Add a photo of your work and describe it in the alt text.',
            'Click Publish, then share the link on Google Business and Facebook.',
        ],
        'tips' => ['Mention your city and service in the title.', 'Link to your contact or quote page.', 'One good article a month beats many thin ones.'],
    ],
];

function guide_url(string $platform): string
{
    return url('posting-guide') . '#' . $platform;
}
