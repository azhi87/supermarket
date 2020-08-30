ALTER TABLE `sale_items` ADD `batch_no` VARCHAR(100) NULL AFTER `exp`;
ALTER TABLE `purchase_items` ADD `batch_no` VARCHAR(100) NULL AFTER `exp`;
ALTER TABLE `stocks` ADD `batch_no` VARCHAR(100) NULL AFTER `exp`;
ALTER TABLE `expenses` ADD `rate` DOUBLE NOT NULL DEFAULT '1250' AFTER `reason`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS brokens;
CREATE TABLE brokens (
  id int(11) NOT NULL,
  item_id int(11) NOT NULL,
  quantity double NOT NULL,
  user_id int(11) NOT NULL,
  exp date NOT NULL,
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE brokens
  ADD PRIMARY KEY (id);


ALTER TABLE brokens
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;


