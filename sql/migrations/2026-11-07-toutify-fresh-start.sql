-- ContentVendor → Toutify sign-in: FRESH START (v2, works on Hostinger MySQL)
-- Run ONCE in phpMyAdmin: select the ContentVendor database → SQL tab → paste ALL of this → Go.
-- Safe to run even if an earlier attempt stopped part-way.
-- WARNING: permanently removes every existing ContentVendor member and their content
-- (profiles, campaigns, content, plans, usage, platform settings). Done-for-you requests are kept
-- (unlinked from members). Back up first: phpMyAdmin → Export.

-- 1. Keep done-for-you requests, but detach them from members
UPDATE service_requests SET user_id = NULL;
ALTER TABLE service_requests DROP FOREIGN KEY fk_request_user;

-- 2. Remove member tables (children and parents together, so foreign keys don't block it)
DROP TABLE IF EXISTS content_items, campaigns, usage_log, business_profiles,
                     plan_tasks, content_plans, member_platforms, password_resets,
                     toutify_sessions, toutify_events, users;

-- 3. Recreate them for Toutify sign-in
CREATE TABLE IF NOT EXISTS users (
  id                 INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  toutify_sub        CHAR(26)     NOT NULL UNIQUE,            -- permanent Toutify member ID
  email              VARCHAR(190) NOT NULL DEFAULT '',
  name               VARCHAR(190) NOT NULL DEFAULT '',
  business_name      VARCHAR(190) NULL,
  phone              VARCHAR(40)  NULL,
  toutify_status     VARCHAR(20)  NOT NULL DEFAULT 'active',  -- active | suspended | closed | deleted
  toutify_updated_at INT UNSIGNED NOT NULL DEFAULT 0,
  role               VARCHAR(20)  NOT NULL DEFAULT 'member',  -- member | admin (admin = sub listed in config toutify.admin_subs)
  plan               VARCHAR(20)  NOT NULL DEFAULT 'starter', -- starter (Free) | pro | premium, from Toutify's tier claim
  deleted_at         DATETIME     NULL,
  created_at         DATETIME     NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS business_profiles (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id       INT UNSIGNED NOT NULL UNIQUE,
  business_name VARCHAR(190) NOT NULL DEFAULT '',
  industry      VARCHAR(120) NOT NULL DEFAULT '',
  services      TEXT,
  location      VARCHAR(190) NOT NULL DEFAULT '',
  service_areas TEXT,
  phone         VARCHAR(40)  NOT NULL DEFAULT '',
  website       VARCHAR(255) NOT NULL DEFAULT '',
  specialties   TEXT,
  description   TEXT,
  brand_voice   VARCHAR(60)  NOT NULL DEFAULT 'friendly',
  audience      VARCHAR(255) NOT NULL DEFAULT '',
  updated_at    DATETIME     NOT NULL,
  CONSTRAINT fk_profile_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS campaigns (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id     INT UNSIGNED NOT NULL,
  goal        VARCHAR(60)  NOT NULL,
  idea        TEXT         NOT NULL,
  created_at  DATETIME     NOT NULL,
  INDEX idx_campaign_user (user_id),
  CONSTRAINT fk_campaign_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS content_items (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id      INT UNSIGNED NOT NULL,
  campaign_id  INT UNSIGNED NULL,
  channel      VARCHAR(40)  NOT NULL,
  title        VARCHAR(255) NOT NULL DEFAULT '',
  body         MEDIUMTEXT   NOT NULL,
  status       VARCHAR(20)  NOT NULL DEFAULT 'draft',  -- draft | approved | scheduled | published
  scheduled_at DATETIME     NULL,
  source       VARCHAR(20)  NOT NULL DEFAULT 'ai',     -- ai | demo | manual
  created_at   DATETIME     NOT NULL,
  updated_at   DATETIME     NOT NULL,
  INDEX idx_item_user_status (user_id, status),
  INDEX idx_item_campaign (campaign_id),
  CONSTRAINT fk_item_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_item_campaign FOREIGN KEY (campaign_id) REFERENCES campaigns(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS usage_log (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id    INT UNSIGNED NOT NULL,
  kind       VARCHAR(30)  NOT NULL DEFAULT 'generation',
  quantity   INT UNSIGNED NOT NULL DEFAULT 1,
  created_at DATETIME     NOT NULL,
  INDEX idx_usage_user_date (user_id, created_at),
  CONSTRAINT fk_usage_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS toutify_sessions (
  session_id VARCHAR(128) NOT NULL PRIMARY KEY,
  sid        CHAR(32)     NULL,
  sub        CHAR(26)     NOT NULL,
  created_at DATETIME     NOT NULL,
  INDEX idx_toutify_sessions_sid (sid),
  INDEX idx_toutify_sessions_sub (sub)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS toutify_events (
  event_id    VARCHAR(40) NOT NULL PRIMARY KEY,
  type        VARCHAR(40) NOT NULL,
  received_at DATETIME    NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Re-link done-for-you requests to the new members table
ALTER TABLE service_requests
  ADD CONSTRAINT fk_request_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;

-- content_plans, plan_tasks and member_platforms are recreated automatically on first use.
