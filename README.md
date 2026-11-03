# ContentVendor

**Create once. Promote everywhere.** The AI content and social media engine for the Toutify network.

ContentVendor turns one business idea ("We're offering $200 off artificial turf installation this month") into a website article, Facebook post, Instagram caption, Pinterest pin, Google Business update, directory promotion, email and video script. Small business owners approve, schedule and publish it from one workspace.

Plain **PHP 8.1+ / MySQL**. No Composer and no build step, so it runs on Hostinger shared hosting as-is.

## What's included (days 1–30 MVP + marketing site)

| Area | Details |
|---|---|
| Marketing site | Home page, pricing ($0 / $19 / $49 plans + feature table), done-for-you packages ($299 / $749 / $999) with a request form |
| Accounts | Sign up, log in and log out, hashed passwords, CSRF protection, secure sessions |
| Business profile | Entered once and used by every tool: services, location, service areas, voice, audience |
| Campaign Builder | Pick a goal, describe the idea, choose destinations, and get one draft per channel from Claude |
| Content library | Search and filter, edit, copy, download (.txt), approve, mark as published, delete |
| Plan limits | Monthly AI generations (5 / 40 / 150), campaign channels (3 on Free, 8 on paid), scheduled posts (0 / 30 / 150) |
| Pro / Premium | Scheduling, monthly calendar, repurposing content into other channels |
| Team dashboard | `/admin`: members, plan changes, estimated MRR, done-for-you request pipeline |
| Demo mode | Without an API key you get template drafts, so the whole site works before AI is connected |

Not built yet (days 31–90 on the roadmap): social network OAuth and auto-publishing, directory publishing to SearchMonster / MonsterList, image generation, the AI monthly planner, content recycling, billing, and the managed-service approval queue.

## Project layout

```
index.php            front controller / router
.htaccess            HTTPS redirect, pretty URLs, blocks private files
app/                 PHP code (blocked from the web by app/.htaccess)
  bootstrap.php      config, session, includes
  helpers.php        DB (PDO), escaping, CSRF, rendering
  plans.php          plans, packages, goals, channels  ← edit limits/pricing here
  ai.php             Claude API client + demo templates
  content.php        usage limits, content helpers
  pages/             one controller per URL
  views/             HTML templates
assets/              CSS and JS
config/              config.sample.php (config.php is git-ignored)
sql/schema.sql       MySQL schema
```

## Deploying to Hostinger from GitHub

1. **Create the database.** In hPanel, go to **Databases → MySQL Databases** and create a database and user. Open **phpMyAdmin**, select the database, then **Import** `sql/schema.sql`.
2. **Connect GitHub.** In hPanel, go to **Advanced → Git**. Add repository `https://github.com/aimbluemedia/contentvendor.git`, branch `main`, and leave the install path empty to deploy into `public_html`. For a private repo, add the deploy key hPanel shows to the repo's GitHub **Settings → Deploy keys**. Click **Deploy**. To deploy automatically on every push, copy the webhook URL from hPanel into GitHub **Settings → Webhooks**.
3. **Create the config.** In **File Manager**, copy `public_html/config/config.sample.php` to `config/config.php` and fill in:
   - `app_url`: your domain
   - `db`: the DSN, user and password from step 1
   - `anthropic.api_key`: a Claude API key from https://platform.claude.com (leave empty for demo mode)
   - `admin_email`: the email you'll register with. That account becomes the admin.
4. **Set PHP.** In **Advanced → PHP Configuration**, choose PHP 8.1 or newer and make sure the `curl` and `pdo_mysql` extensions are enabled (they are by default). Set `max_execution_time` to at least 240 so long campaigns can finish.
5. **Enable SSL** in hPanel (free). The `.htaccess` file forces HTTPS.
6. Visit your site, register with the admin email, then fill in the business profile.

`config/config.php` is never committed, so redeploys from GitHub won't overwrite your secrets.

## Local development

```bash
cp config/config.sample.php config/config.php   # point db.dsn at a local MySQL
php -S localhost:8000 index.php
```

## AI notes

- Model: `claude-opus-5-5` by default (`anthropic.model` in config). Effort is `medium`. Output uses JSON-schema structured output, so each channel comes back as a clean draft.
- Server-side refusal fallback is on by default (`anthropic.fallbacks`).
- One generation = one content item. A campaign with 8 destinations uses 8 generations.
- The system prompt tells the AI never to invent reviews, prices or guarantees, and to write each destination as its own piece instead of duplicating text across directories.

## Changing plans and pricing

Edit `app/plans.php`. Plan limits, the comparison table, done-for-you packages, goals and channel writing guides all live there. Until billing is connected, admins change a member's plan from `/admin`, and "Upgrade" buttons go to `upgrade_url` in the config (your Toutify subscription page).
