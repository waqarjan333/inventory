-- This script will create two table with the name 'item_warehouse' and 'stock_transfer'
--  Add warehouse_id column in 'pos_invoice_detail' table and 'po_invoice_detail' table

ALTER TABLE `po_invoice_detail` ADD `warehouse_id` INT NOT NULL AFTER `unit_id`;
ALTER TABLE `pos_invoice_detail` ADD `warehouse_id` INT NOT NULL AFTER `unit_id`;
ALTER TABLE `stock_adjust` ADD `conv_from` INT NOT NULL AFTER `qty`;
ALTER TABLE `warehouses` ADD `reorder_qty` INT NOT NULL AFTER `last_changed`;
ALTER TABLE `stock_transfer` ADD `conv_from` INT NOT NULL AFTER `qty`;
ALTER TABLE `po_invoice_detail` CHANGE `inv_item_quantity` `inv_item_quantity` DOUBLE NOT NULL;
ALTER TABLE `item` CHANGE `quantity` `quantity` DOUBLE NOT NULL;
ALTER TABLE `stock_transfer` ADD `invoice_no` INT NOT NULL AFTER `id`;

ALTER TABLE `po_invoice_detail` CHANGE `inv_item_discount` `inv_item_discount` DOUBLE NOT NULL;

CREATE TABLE `item_warehouse` (
  `id` int(11) NOT NULL,
  `inv_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` double NOT NULL,
  `conv_from` varchar(20) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `invoice_type` int(11) NOT NULL,
  `invoice_status` varchar(50) NOT NULL,
  `inv_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `item_warehouse` ADD PRIMARY KEY(`id`);
ALTER TABLE `item_warehouse` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;




CREATE TABLE `stock_transfer` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` double NOT NULL,
  `unit_id` int(11) NOT NULL,
  `from_warehouse` int(11) NOT NULL,
  `to_warehouse` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `stock_transfer` ADD PRIMARY KEY(`id`);
ALTER TABLE `stock_transfer` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;


-- WareHouse Reorder Tabe
CREATE TABLE `warehouse_reorder` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `reorder_qty` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `warehouse_reorder`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `warehouse_reorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

-- This script insert all existing product quantity into 'item_warehouse' Table 


-- 1: FOR OPENING QUANTITY SCRIPT FOR 'ITEM_WAREHOUSE' TABLE
-- -- ========================================================
INSERT INTO `item_warehouse` (`item_id`,`qty`,`inv_date`)
SELECT `id`, `quantity`,`added_date` FROM `item`;
UPDATE `item_warehouse` SET `conv_from`='1',`warehouse_id`='1',`unit_id`='1',`invoice_type`='6',`invoice_status`='{{Opening Quantity}}';

-- 2:FOR SALE ORDERS QUANTITY IN 'ITEM_WAREHOUSE' TABLE
-- -- =====================================================
INSERT INTO `item_warehouse` (`inv_id`,`item_id`,`qty`,`conv_from`,`warehouse_id`,`unit_id`,`inv_date`)
SELECT `inv_id`, `inv_item_id`,(-1 *`item_quantity`),`conv_from`,`warehouse_id`,`unit_id`,`invoice_date` FROM `pos_invoice_detail` LEFT JOIN `pos_invoice` ON (pos_invoice.invoice_id=pos_invoice_detail.inv_id) WHERE pos_invoice.sale_return='0';

UPDATE `item_warehouse` SET `invoice_type`='2',`invoice_status`='{{Sale Order}}' WHERE invoice_type='0';

-- 3:FOR SALE RETURN QUANTITY IN 'ITEM_WAREHOUSE' Table
-- -- =================================================
INSERT INTO `item_warehouse` (`inv_id`,`item_id`,`qty`,`conv_from`,`warehouse_id`,`unit_id`,`inv_date`)
SELECT `inv_id`, `inv_item_id`,(-1 * `item_quantity`),`conv_from`,`warehouse_id`,`unit_id`,`invoice_date` FROM `pos_invoice_detail` LEFT JOIN `pos_invoice` ON (pos_invoice.invoice_id=pos_invoice_detail.inv_id) WHERE pos_invoice.sale_return='1';

UPDATE `item_warehouse` SET `invoice_type`='1',`invoice_status`='{{SALE RETURN}}'  WHERE invoice_type='0';

-- 4:FOR PURCHASE ORDER QUNATITY IN 'ITEM_WAREHOUSE' TABLE
-- -- =========================================================
INSERT INTO `item_warehouse` (`inv_id`,`item_id`,`qty`,`conv_from`,`warehouse_id`,`unit_id`,`inv_date`)
SELECT `inv_id`, `inv_item_id`,`item_quantity`,`conv_from`,`warehouse_id`,`unit_id`,`invoice_date` FROM `po_invoice_detail` LEFT JOIN `po_invoice` ON (po_invoice.invoice_id=po_invoice_detail.inv_id) WHERE
 po_invoice.invoice_type='1';

UPDATE `item_warehouse` SET `invoice_type`='4',`invoice_status`='{{Purchase Order}}' WHERE invoice_type='0';


-- 5:FOR PURCHASE RETRUN QUNATITY IN 'ITEM_WAREHOUSE' TABLE
-- ===========================================================
INSERT INTO `item_warehouse` (`inv_id`,`item_id`,`qty`,`conv_from`,`warehouse_id`,`unit_id`,`inv_date`)
SELECT `inv_id`, `inv_item_id`,`item_quantity`,`conv_from`,`warehouse_id`,`unit_id`,`invoice_date` FROM `po_invoice_detail` LEFT JOIN `po_invoice` ON (po_invoice.invoice_id=po_invoice_detail.inv_id) WHERE
 po_invoice.invoice_type='2';

UPDATE `item_warehouse` SET `invoice_type`='5',`invoice_status`='{{Purchase Return}}' WHERE invoice_type='0';


-- 6:FOR STOCK ADJUST QUANTITY IN 'ITEM_WAREHOUSE' TABLE
-- ========================================================
INSERT INTO `item_warehouse` (`item_id`,`qty`,`inv_date`)
SELECT `item_id`, `qty`,`updated_date` FROM `stock_adjust`;

UPDATE `item_warehouse` SET `conv_from`='1',`warehouse_id`='1',`unit_id`='1',`invoice_type`='7',`invoice_status`='{{Stock Adjust}}'  WHERE `invoice_type`='0' ;

-- 6:FOR STOCK TRANSFER QUANTITY IN 'ITEM_WAREHOUSE' TABLE
-- ========================================================
INSERT INTO `item_warehouse` (`inv_id`,`item_id`,`qty`,`conv_from`,`warehouse_id`,`unit_id`,`inv_date`) SELECT `invoice_no`, `item_id`,qty,`conv_from`,`to_warehouse`,`unit_id`,`date` FROM `stock_transfer`
UPDATE `item_warehouse` SET `invoice_type`='8',`invoice_status`='{{STOCK TRANSFER}}' WHERE invoice_type='0'

UPDATE `pos_invoice_detail` SET `warehouse_id`=1 WHERE `warehouse_id`=0;
UPDATE `po_invoice_detail` SET `warehouse_id`=1 WHERE `warehouse_id`=0;
UPDATE `item_warehouse` SET `warehouse_id`=1 WHERE `warehouse_id`=0;
UPDATE `po_receive` SET `rec_warehouse`=1 WHERE `rec_warehouse`=0;
UPDATE `stock_adjust` SET `conv_from`=1 WHERE `conv_from`=0;



    CREATE TABLE `labels` (
  `id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL,
  `type` int(2) NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  ALTER TABLE `labels`
  ADD PRIMARY KEY (`id`);
  ALTER TABLE `labels`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

-- journal_invoice Table
  CREATE TABLE `journal_invoice` (
  `inv_id` int(11) NOT NULL,
  `entry_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '20',
  `inv_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
  ALTER TABLE `journal_invoice`
  ADD PRIMARY KEY (`inv_id`);
  ALTER TABLE `journal_invoice`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT;

-- ournal_invoice_details Table
  CREATE TABLE `journal_invoice_details` (
  `id` int(11) NOT NULL,
  `inv_id` int(11) NOT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `acc_name` varchar(256) CHARACTER SET utf8mb4 NOT NULL,
  `debit_amount` double DEFAULT NULL,
  `credit_amount` double DEFAULT NULL,
  `memo` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_` varchar(256) CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

  ALTER TABLE `journal_invoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inv_id` (`inv_id`);

ALTER TABLE `journal_invoice_details`
  ADD CONSTRAINT `journal_invoice_details_ibfk_1` FOREIGN KEY (`inv_id`) REFERENCES `journal_invoice` (`inv_id`);
ALTER TABLE price_level ADD level_from_date DATE NULL AFTER level_detail, ADD level_to_date DATE NULL AFTER level_from_date;


ALTER TABLE `item_warehouse` CHANGE `qty` `qty` DOUBLE NOT NULL;
ALTER TABLE `stock_transfer` CHANGE `qty` `qty` DOUBLE NOT NULL;
ALTER TABLE `po_invoice_detail` ADD `bonus_qty` DOUBLE NOT NULL AFTER `inv_item_quantity`;
ALTER TABLE `pos_invoice_detail` ADD `bonus_qty` DOUBLE NOT NULL AFTER `inv_item_quantity`;
