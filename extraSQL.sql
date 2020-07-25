-- ALTER TABLE `purchases` ADD `type` ENUM('purchase','returned_purchase') NOT NULL DEFAULT 'purchase' AFTER `user_id`;
-- ALTER TABLE `sales` ADD `type` ENUM('sale','returned_sale') NOT NULL DEFAULT 'sale' AFTER `user_id`;
-- ALTER TABLE `stocks` ADD `ppi` DOUBLE NOT NULL AFTER `description`, ADD `rate` DOUBLE NOT NULL AFTER `ppi`;

    -- insert sales amounts to stock
    SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS stocks;
CREATE TABLE stocks (
  id int(11) NOT NULL,
  item_id int(11) NOT NULL,
  quantity double NOT NULL,
  exp date DEFAULT NULL,
  type enum('broken','sale','purchase','return','returned_sale','returned_purchase') COLLATE utf8mb4_unicode_ci NOT NULL,
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  source_id int(11) NOT NULL,
  description text COLLATE utf8mb4_unicode_ci,
  ppi double NOT NULL,
  rate double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE stocks
  ADD PRIMARY KEY (id);


ALTER TABLE stocks
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE manufacturers (
  id int(11) NOT NULL,
  name varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE manufacturers
  ADD PRIMARY KEY (id);


ALTER TABLE manufacturers
  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE paybacks (
  id int(10) UNSIGNED NOT NULL,
  user_id int(11) NOT NULL,
  discount double NOT NULL,
  currency enum('IQD','$') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'IQD',
  paid double NOT NULL,
  supplier_id int(11) NOT NULL,
  description text COLLATE utf8mb4_unicode_ci,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE paybacks
  ADD PRIMARY KEY (id);


ALTER TABLE paybacks
  MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;


    INSERT INTO stocks
            (item_id,quantity,type,source_id,description,created_at,updated_at,ppi,exp,rate)
    SELECT
             item_id,(-1 * ((si.singles/items_per_box)+si.quantity)),'sale',sale_id,'add Sale Itme' ,sales.created_at,sales.updated_at,ppi,si.exp,rate
    FROM sale_items si
                        join items i on si.item_id=i.id
                        join sales on si.sale_id=sales.id
                        where sales.type="sale";

  -- insert returned sales to stock

      INSERT INTO stocks
            (item_id,quantity,type,source_id,description,created_at,updated_at,ppi,exp,rate)
    SELECT
             item_id,((si.singles/items_per_box)+si.quantity),'returned_sale',sale_id,'return sale titem' ,sales.created_at,sales.updated_at,-1 * ppi,si.exp,rate
    FROM sale_items si
                        join items i on si.item_id=i.id
                        join sales on si.sale_id=sales.id
                        where sales.type="returned_sale";

-- insert purchase items to stock
        INSERT INTO stocks
                (item_id,quantity,type,source_id,description,created_at,updated_at,ppi,exp,rate)
        SELECT
                item_id,((pi.singles/items_per_box)+pi.quantity),'purchase',purchase_id,'add purchase item' ,purchases.created_at,purchases.updated_at,-1 * ppi,pi.exp,0
        FROM purchase_items pi
                            join items i on pi.item_id=i.id
                            join purchases on pi.purchase_id=purchases.id
                            where purchases.type="purchase";

  -- insert returned sales to stock

      INSERT INTO stocks
            (item_id,quantity,type,source_id,description,created_at,updated_at,ppi,exp,rate)
    SELECT
             item_id,-1 * ((pi.singles/items_per_box)+pi.quantity),'returned_purchase',purchase_id,'return purchase titem' ,purchases.created_at,purchases.updated_at,ppi,pi.exp,0
    FROM purchase_items pi
                        join items i on pi.item_id=i.id
                        join purchases on pi.purchase_id=purchases.id
                        where purchases.type="returned_purchase";