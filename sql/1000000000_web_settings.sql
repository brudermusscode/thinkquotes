CREATE TABLE web_settings (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(32) NOT NULL,
  is_maintenance TINYINT default 0,
  version VARCHAR(12) default "0.0.1",
  privacy_policies_updated_at TIMESTAMP NULL,

  deleted_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ALTER TABLE quotes
--   ADD is_default TINYINT DEFAULT 0 AFTER product_id;