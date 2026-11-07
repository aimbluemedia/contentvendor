-- Toutify websites. OPTIONAL: ContentVendor creates these automatically on first use.
-- Run in phpMyAdmin only if you prefer to create them by hand. Safe to run more than once.
-- (users.website is added automatically on first use.)

CREATE TABLE IF NOT EXISTS toutify_websites (
  id                 CHAR(26)     NOT NULL PRIMARY KEY,
  owner              CHAR(26)     NOT NULL,
  url                VARCHAR(255) NOT NULL DEFAULT '',
  business_name      VARCHAR(150) NOT NULL DEFAULT '',
  phone              VARCHAR(40)  NULL,
  street             VARCHAR(150) NULL,
  city               VARCHAR(120) NULL,
  state              VARCHAR(60)  NULL,
  zip                VARCHAR(20)  NULL,
  country            VARCHAR(60)  NULL,
  tier               VARCHAR(20)  NOT NULL DEFAULT '',
  status             VARCHAR(20)  NOT NULL DEFAULT 'active',
  toutify_updated_at INT UNSIGNED NOT NULL DEFAULT 0,
  INDEX idx_toutify_websites_owner (owner)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
