-- ContentVendor → Toutify sign-in: FRESH START
-- Run ONCE in phpMyAdmin (select the ContentVendor database → SQL tab) right after deploying.
-- WARNING: this permanently removes every existing ContentVendor member and their content
-- (profiles, campaigns, content, plans, usage, platform settings, reset links).
-- Done-for-you requests are kept but unlinked from members. Back up first (phpMyAdmin → Export).

SET FOREIGN_KEY_CHECKS = 0;

UPDATE service_requests SET user_id = NULL;

TRUNCATE TABLE content_items;
TRUNCATE TABLE campaigns;
TRUNCATE TABLE usage_log;
TRUNCATE TABLE business_profiles;
DROP TABLE IF EXISTS plan_tasks;
DROP TABLE IF EXISTS content_plans;
DROP TABLE IF EXISTS member_platforms;
DROP TABLE IF EXISTS password_resets;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id                 INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  toutify_sub        CHAR(26)     NOT NULL UNIQUE,
  email              VARCHAR(190) NOT NULL DEFAULT '',
  name               VARCHAR(190) NOT NULL DEFAULT '',
  business_name      VARCHAR(190) NULL,
  phone              VARCHAR(40)  NULL,
  toutify_status     VARCHAR(20)  NOT NULL DEFAULT 'active',
  toutify_updated_at INT UNSIGNED NOT NULL DEFAULT 0,
  role               VARCHAR(20)  NOT NULL DEFAULT 'member',
  plan               VARCHAR(20)  NOT NULL DEFAULT 'starter',
  deleted_at         DATETIME     NULL,
  created_at         DATETIME     NOT NULL
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

SET FOREIGN_KEY_CHECKS = 1;
-- content_plans, plan_tasks and member_platforms are recreated automatically on first use.
