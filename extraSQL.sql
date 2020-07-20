ALTER TABLE `purchases` ADD `type` ENUM('purchase','returned_purchase') NOT NULL DEFAULT 'purchase' AFTER `user_id`;
ALTER TABLE `sales` ADD `type` ENUM('sale','returned_sale') NOT NULL DEFAULT 'sale' AFTER `user_id`;
