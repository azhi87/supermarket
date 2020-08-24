ALTER TABLE `sale_items` ADD `batch_no` VARCHAR(100) NULL AFTER `exp`;
ALTER TABLE `purchase_items` ADD `batch_no` VARCHAR(100) NULL AFTER `exp`;
ALTER TABLE `stocks` ADD `batch_no` VARCHAR(100) NULL AFTER `exp`;
