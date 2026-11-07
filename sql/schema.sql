-- ContentVendor MySQL schema (MySQL 5.7+/MariaDB 10.3+, utf8mb4)
-- Import via Hostinger hPanel > Databases > phpMyAdmin > Import

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS users (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(120) NOT NULL,
  email         VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role          VARCHAR(20)  NOT NULL DEFAULT 'member',   -- member | admin
  plan          VARCHAR(20)  NOT NULL DEFAULT 'starter',  -- starter | pro | premium
  created_at    DATETIME     NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Shared Toutify Business Profile: entered once, used by every tool
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

-- One idea -> many channel drafts
CREATE TABLE IF NOT EXISTS campaigns (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id     INT UNSIGNED NOT NULL,
  goal        VARCHAR(60)  NOT NULL,
  idea        TEXT         NOT NULL,
  created_at  DATETIME     NOT NULL,
  INDEX idx_campaign_user (user_id),
  CONSTRAINT fk_campaign_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Content library: every generated or hand-written piece
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

-- Usage ledger for monthly plan limits (1 row = 1 content item generated)
CREATE TABLE IF NOT EXISTS usage_log (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id    INT UNSIGNED NOT NULL,
  kind       VARCHAR(30)  NOT NULL DEFAULT 'generation',
  quantity   INT UNSIGNED NOT NULL DEFAULT 1,
  created_at DATETIME     NOT NULL,
  INDEX idx_usage_user_date (user_id, created_at),
  CONSTRAINT fk_usage_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Done-for-you package requests ($299 / $749 / $999)
CREATE TABLE IF NOT EXISTS service_requests (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id    INT UNSIGNED NULL,
  package    VARCHAR(30)  NOT NULL,
  name       VARCHAR(120) NOT NULL,
  email      VARCHAR(190) NOT NULL,
  phone      VARCHAR(40)  NOT NULL DEFAULT '',
  business   VARCHAR(190) NOT NULL DEFAULT '',
  message    TEXT,
  status     VARCHAR(20)  NOT NULL DEFAULT 'new',   -- new | contacted | active | closed
  created_at DATETIME     NOT NULL,
  CONSTRAINT fk_request_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- AI content plan + daily tasks (also created automatically on first use)
CREATE TABLE IF NOT EXISTS content_plans (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id    INT NOT NULL,
  platforms  VARCHAR(255) NOT NULL,
  minutes    INT NOT NULL,
  days       VARCHAR(20) NOT NULL,
  active     TINYINT NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS plan_tasks (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  plan_id      INT NOT NULL,
  user_id      INT NOT NULL,
  due_date     DATE NOT NULL,
  platform     VARCHAR(40) NOT NULL,
  goal         VARCHAR(40) NOT NULL,
  idea         TEXT NOT NULL,
  status       VARCHAR(20) NOT NULL DEFAULT 'todo',  -- todo | done | skipped
  item_id      INT NULL,
  completed_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password reset links (also created automatically on first use)
CREATE TABLE IF NOT EXISTS password_resets (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id    INT NOT NULL,
  token_hash CHAR(64) NOT NULL,
  expires_at DATETIME NOT NULL,
  used_at    DATETIME NULL,
  created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Social platform switches (also created automatically on first use)
CREATE TABLE IF NOT EXISTS member_platforms (
  user_id    INT NOT NULL PRIMARY KEY,
  platforms  VARCHAR(255) NOT NULL,
  updated_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
