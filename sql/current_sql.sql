
--This Script Will change empty DB from ENGLISH to URDU  (Change Default values from ENGLISH to URDU)

UPDATE `category` SET `name`='پہلے سے طے شدہ', `description`='طے شدہ کیٹیگری' WHERE `id`='1';item
UPDATE `customer` SET `cust_name`='نقد گاہک' WHERE `cust_id`=0;
UPDATE `customer_groups` SET `cust_group_name`='طے شدہ گروپ' WHERE `id`=1;
UPDATE `customer_types` SET `cust_type_name`='طے شدہ' WHERE `id`=1;
UPDATE `salesrep` SET `salesrep_name`='طے شدہ فروخت کندہ' WHERE `id`=1;
UPDATE `warehouses` SET `warehouse_name`='طے شدہ مقام' WHERE `warehouse_id`=1;


--This Script Will change empty DB from URDU to ENGLISH  (Change Default values from ENGLISH to URDU)

UPDATE `category` SET `name`='Default', `description`='Default Category' WHERE `id`='1';
UPDATE `customer` SET `cust_name`='Walk In Customer' WHERE `cust_id`=0;
UPDATE `customer_groups` SET `cust_group_name`='Default Group' WHERE `id`=1;
UPDATE `customer_types` SET `cust_type_name`='Default' WHERE `id`=1;
UPDATE `salesrep` SET `salesrep_name`='Default Rep' WHERE `id`=1;
UPDATE `warehouses` SET `warehouse_name`='Default Location' WHERE `warehouse_id`=1;

ALTER TABLE `pos_invoice_detail` CHANGE `discount` `inv_item_discount` DOUBLE NOT NULL;

ALTER TABLE `pos_invoice` CHANGE `discount` `discount` DOUBLE NOT NULL;
ALTER TABLE `pos_invoice_detail` CHANGE `inv_item_discount` DOUBLE NOT NULL;
ALTER TABLE `po_invoice` ADD `discount_invoice` DOUBLE NOT NULL AFTER `payment_method`;
ALTER TABLE `customer` ADD `order_no` DOUBLE NOT NULL AFTER `cust_credit_limit`;
ALTER TABLE `item` ADD `opening_cost` DOUBLE NOT NULL AFTER `picture`;
ALTER TABLE `stock_adjust` ADD `adjust_amount` DOUBLE NOT NULL AFTER `conv_from`;
ALTER TABLE `pos_invoice` CHANGE `discount` `discount` DOUBLE NOT NULL;
ALTER TABLE `pos_invoice_detail` CHANGE `inv_item_discount` `inv_item_discount` DOUBLE NOT NULL;
ALTER TABLE `po_invoice_detail` CHANGE `inv_item_discount` `inv_item_discount` DOUBLE NOT NULL;
ALTER TABLE `account_journal` CHANGE `journal_details` `journal_details` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `customer` ADD `cust_cnic` VARCHAR(30) NOT NULL AFTER `cust_address`;
