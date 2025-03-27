CREATE TABLE quotes (
  id INT NOT NULL AUTO_INCREMENT,
  author_id INT NOT NULL,
  text TEXT NOT NULL,
  loves INT NOT NULL default 0,
  hates INT NOT NULL default 0,

  deleted_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ALTER TABLE quotes
--   ADD is_default TINYINT DEFAULT 0 AFTER product_id;