<?php
/**
 * Privacy Policy and Terms of Service content.
 * Company name, contact email, address and governing law come from config('legal.*').
 * Each section: [heading, [paragraphs or ['list' => [...]] ]]
 */

function legal_company(): string { return (string) (config('legal.company') ?: 'Global Media Inc'); }

function legal_contact_html(): string
{
    $email = trim((string) (config('legal.email') ?: 'support@toutify.com'));
    $addr = trim((string) (config('legal.address') ?: "2700 S Gilbert Rd, Suite 199\nChandler, AZ 85286"));
    $out = $email !== '' ? 'Email: <a href="mailto:' . e($email) . '">' . e($email) . '</a>' : 'Use the contact options in your Toutify account or on toutify.com.';
    if ($addr !== '') $out .= '<br>Mail: ' . nl2br(e($addr));
    return $out;
}

function legal_updated(): string { return (string) (config('legal.updated') ?: 'November 13, 2026'); }

function legal_privacy(): array
{
    $co = legal_company();
    return [
        ['Who we are', [
            "ContentVendor is an AI content and social media service for small businesses, provided by {$co} (\"we\", \"us\") as part of the Toutify membership. This policy explains what information ContentVendor collects, how we use it and the choices you have.",
        ]],
        ['Information we collect', [
            '**Account information from Toutify.** You sign in with your Toutify account. When you do, Toutify shares your member ID, name, email address, phone number, business name, main website and the websites in your membership, along with your account status and website plan. We never see or store your Toutify password.',
            '**Your business profile.** The details you add, such as industry, services, location, service areas, specialties, description, brand voice and audience.',
            '**Content you create.** The ideas you type, the drafts the AI writes, your edits, your content plan and tasks, and the status of each post (draft, approved, scheduled or published).',
            '**Usage and activity.** How many AI drafts you use each month, your scheduled posts and the activity shown on your performance dashboard. We use this to apply plan limits and show your stats.',
            '**Done-for-you requests.** If you request a package or free trial, the name, email, phone, business name and message you send us.',
            '**Website checker.** If you use the free visibility check, we fetch the public web page you enter once to produce your result. We don\'t store that address or the page.',
            '**Technical information.** A session cookie that keeps you signed in, and standard server logs kept by our hosting provider (such as IP address, browser type and pages requested).',
        ]],
        ['How we use your information', [
            ['list' => [
                'To provide ContentVendor: your library, content plan, calendar, prompts and dashboard.',
                'To write content for you with AI, using your business profile and the ideas you enter.',
                'To apply your plan\'s features and monthly limits, which come from your Toutify membership.',
                'To respond to done-for-you requests, deliver trial content and send subscription details if you choose to continue.',
                'To keep the service secure, prevent abuse and fix problems.',
                'To improve ContentVendor and develop new features.',
            ]],
            'We do not sell your personal information and we do not use it for advertising.',
        ]],
        ['AI processing', [
            'To write drafts, ContentVendor sends your business profile and the text you enter to Anthropic\'s Claude API. Anthropic processes this information to return the draft, under its commercial terms for API customers. Please don\'t enter sensitive personal information (such as health, financial or government ID details) about yourself or others into ContentVendor.',
            'AI-written drafts can contain mistakes. Review every draft before you publish it.',
        ]],
        ['Who we share information with', [
            ['list' => [
                'Toutify, which runs your membership, sign-in and billing for ContentVendor plans.',
                'Anthropic, which provides the AI that writes your drafts.',
                'Our hosting provider, which stores the website and database.',
                'A payment provider, if you subscribe to a done-for-you package through a payment link we send you.',
                'Authorities or others when required by law, or to protect the rights, safety and security of our users and the service.',
                'A buyer or successor if our business is sold or reorganised, under this policy.',
            ]],
            'ContentVendor does not post to your social media accounts or connect to them. You publish your content yourself with the apps you choose.',
        ]],
        ['Cookies', [
            'ContentVendor uses one essential cookie, cv_session, which keeps you signed in and protects forms from misuse. It expires after about two hours of inactivity or when you sign out. We don\'t use advertising or analytics cookies.',
        ]],
        ['How long we keep information', [
            'We keep your account, profile and content while your membership is active so you can use your library. If your Toutify account is closed or deleted, we mark your ContentVendor account as deleted and sign you out everywhere. You can ask us to delete your content at any time. We keep done-for-you requests for as long as needed to handle them and meet our legal and accounting obligations. Server logs are kept for a limited time by our hosting provider.',
        ]],
        ['Your choices and rights', [
            ['list' => [
                'Update your name, email, phone and websites on Toutify. ContentVendor picks up the changes automatically.',
                'Edit your business profile in ContentVendor at any time.',
                'Copy or download any content in your library.',
                'Ask us for a copy of your information, to correct it or to delete it.',
            ]],
            'Depending on where you live, you may have additional privacy rights, such as the right to know, access, correct or delete personal information, and to not be discriminated against for using these rights. Contact us to make a request. We may need to verify your identity first.',
        ]],
        ['Security', [
            'We use reasonable safeguards to protect your information, including encrypted connections, signed sign-in tokens and access controls. No online service can be guaranteed 100% secure, so please keep your Toutify login safe.',
        ]],
        ['Children', [
            'ContentVendor is a business tool for adults. It is not directed to children under 13, and we don\'t knowingly collect their information.',
        ]],
        ['International use', [
            'Your information may be processed in the United States and other countries where we and our providers operate, which may have different data protection laws than where you live.',
        ]],
        ['Changes to this policy', [
            'We may update this policy from time to time. If we make significant changes, we\'ll update the date above and, where appropriate, let you know in ContentVendor or by email.',
        ]],
        ['Contact us', ['__contact__']],
    ];
}

function legal_terms(): array
{
    $co = legal_company();
    $law = trim((string) (config('legal.governing_law') ?: 'the State of Arizona'));
    return [
        ['Agreement', [
            "These Terms of Service (\"Terms\") are an agreement between you and {$co} (\"we\", \"us\") for your use of ContentVendor. By creating an account or using ContentVendor, you agree to these Terms and our Privacy Policy. If you use ContentVendor for a business, you agree on behalf of that business.",
        ]],
        ['Your account', [
            'You sign in to ContentVendor with your Toutify account, and your Toutify membership terms also apply. You must be at least 18 and use ContentVendor for a lawful business purpose. You are responsible for activity under your account and for keeping your login secure.',
        ]],
        ['Plans, limits and billing', [
            'ContentVendor plans (Free, Pro and Premium) are part of your Toutify membership and are billed by Toutify. Each plan includes the features and monthly limits shown on our pricing page, such as AI drafts and scheduled posts. Monthly limits reset on the 1st of each month and unused amounts don\'t carry over. We may change plans, prices or limits in the future. If a change affects what you pay, we\'ll give you notice before it applies.',
        ]],
        ['Done-for-you services', [
            'If you request a done-for-you package, we may offer a free trial in which our team creates sample content for your business, such as 4 website articles and 4 social media posts. There is no obligation to continue after the trial. If you choose to continue, we\'ll send you a subscription payment link. Done-for-you subscriptions are month to month and you can pause or cancel at any time. Cancelling stops future charges. Payments already made are not refunded unless required by law or we agree otherwise in writing.',
            'You agree to give us accurate information about your business and to review content before it is published. Original video production and on-site photography are not included unless we agree otherwise in writing.',
        ]],
        ['AI-generated content', [
            'ContentVendor uses artificial intelligence to write drafts. AI can make mistakes, and drafts may contain errors, outdated information or claims that don\'t fit your business. You are responsible for reviewing, editing and approving all content before you publish it, and for making sure it is accurate and complies with the law and the rules of each platform where you post it, including rules about advertising, offers, pricing and reviews.',
            'We do not guarantee any particular result, such as search rankings, mentions by AI assistants, engagement, leads or sales.',
        ]],
        ['Your content', [
            'You keep ownership of the information you provide and, as between you and us, the content created for you in ContentVendor. You give us permission to store, process and display your content as needed to provide and improve the service, including sending it to our AI provider to write drafts. Similar content may be created for other users, because AI can produce similar text from similar requests.',
        ]],
        ['Acceptable use', [
            'You agree not to use ContentVendor to:',
            ['list' => [
                'Break any law or regulation, or help others do so.',
                'Create false, misleading or deceptive content, including fake reviews or testimonials.',
                'Create spam, harassment, hateful content or content that infringes someone else\'s rights.',
                'Impersonate any person or business.',
                'Interfere with, overload, scrape or reverse-engineer the service, or get around plan limits.',
                'Resell or share access to ContentVendor without our written permission.',
            ]],
        ]],
        ['Other services and tools', [
            'ContentVendor helps you publish on services we don\'t control, such as social networks, search engines, directories and creative tools like Canva or ChatGPT. Your use of those services is governed by their own terms. ContentVendor does not connect to or post on those services for you.',
        ]],
        ['Changes and availability', [
            'We are constantly improving ContentVendor and may add, change or remove features. We aim to keep the service available, but it may sometimes be interrupted for maintenance, updates or reasons outside our control.',
        ]],
        ['Ending your use', [
            'You can stop using ContentVendor at any time. We may suspend or end your access if you break these Terms, if your Toutify membership ends, or if we need to for legal or security reasons. If your account ends, you may lose access to your library, so copy or download anything you want to keep.',
        ]],
        ['Disclaimers', [
            'ContentVendor is provided "as is" and "as available". To the fullest extent allowed by law, we disclaim all warranties, express or implied, including warranties of merchantability, fitness for a particular purpose and non-infringement.',
        ]],
        ['Limitation of liability', [
            'To the fullest extent allowed by law, we are not liable for any indirect, incidental, special, consequential or punitive damages, or for lost profits, revenue, data or business opportunities. Our total liability for any claim relating to ContentVendor is limited to the amount you paid us for ContentVendor in the 12 months before the claim, or $100 if you paid nothing.',
        ]],
        ['Indemnity', [
            'You agree to defend and indemnify us against claims, losses and expenses arising from content you publish, your use of ContentVendor or your breach of these Terms.',
        ]],
        ['Governing law', [
            $law !== ''
                ? "These Terms are governed by the laws of {$law}, without regard to its conflict of laws rules."
                : 'These Terms are governed by the laws of the state where we are established, without regard to its conflict of laws rules.',
        ]],
        ['Changes to these Terms', [
            'We may update these Terms from time to time. If we make significant changes, we\'ll update the date above and, where appropriate, let you know in ContentVendor or by email. Continuing to use ContentVendor after changes take effect means you accept the updated Terms.',
        ]],
        ['Contact us', ['__contact__']],
    ];
}
