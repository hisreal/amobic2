CREATE TABLE IF NOT EXISTS properties (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  draft_id INT UNSIGNED NULL,
  full_address VARCHAR(255) NOT NULL,
  suburb_area VARCHAR(160) NOT NULL,
  landmark VARCHAR(160) NULL,
  property_types JSON NOT NULL,
  bedrooms VARCHAR(20) NOT NULL,
  bathrooms VARCHAR(20) NOT NULL,
  parking VARCHAR(40) NOT NULL,
  occupancy_type VARCHAR(40) NOT NULL,
  furnishing_status VARCHAR(60) NOT NULL,
  wifi_internet VARCHAR(20) NOT NULL,
  wifi_speed VARCHAR(60) NULL,
  load_shedding_solution VARCHAR(60) NOT NULL,
  air_conditioning VARCHAR(20) NOT NULL,
  swimming_pool VARCHAR(20) NOT NULL,
  braai_outdoor_area VARCHAR(20) NOT NULL,
  washing_machine VARCHAR(20) NOT NULL,
  access_control VARCHAR(20) NOT NULL,
  cctv_alarm VARCHAR(20) NOT NULL,
  smoking_policy VARCHAR(60) NOT NULL,
  events_parties VARCHAR(60) NOT NULL,
  pets_allowed VARCHAR(60) NOT NULL,
  status ENUM('pending_review','active','inactive') NOT NULL DEFAULT 'pending_review',
  payload_json JSON NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_properties_user_id (user_id),
  INDEX idx_properties_draft_id (draft_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS property_images (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  property_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  original_name VARCHAR(180) NULL,
  sort_order INT UNSIGNED NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_property_images_property
    FOREIGN KEY (property_id) REFERENCES properties(id)
    ON DELETE CASCADE,
  INDEX idx_property_images_property_id (property_id),
  INDEX idx_property_images_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS property_drafts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  draft_token CHAR(32) NOT NULL,
  payload_json JSON NOT NULL,
  image_paths JSON NULL,
  completion_percentage TINYINT UNSIGNED NOT NULL DEFAULT 0,
  last_completed_step TINYINT UNSIGNED NOT NULL DEFAULT 0,
  status ENUM('in_progress','completed') NOT NULL DEFAULT 'in_progress',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  completed_at TIMESTAMP NULL,
  UNIQUE KEY uq_property_drafts_token (draft_token),
  INDEX idx_property_drafts_user_status (user_id, status),
  INDEX idx_property_drafts_user_updated (user_id, updated_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Prepared insert query used by config/property-submit.php:
-- INSERT INTO properties (
--   user_id, draft_id, full_address, suburb_area, landmark, property_types, bedrooms, bathrooms,
--   parking, occupancy_type, furnishing_status, wifi_internet, wifi_speed, load_shedding_solution,
--   air_conditioning, swimming_pool, braai_outdoor_area, washing_machine, access_control, cctv_alarm,
--   smoking_policy, events_parties, pets_allowed, payload_json
-- ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
