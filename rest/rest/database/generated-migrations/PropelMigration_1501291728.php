<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1501291728.
 * Generated on 2017-07-29 01:28:48 by vagrant
 */
class PropelMigration_1501291728
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'ingles200h' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

USE `mysql`;

DROP DATABASE IF EXISTS `ingles200h`;

CREATE DATABASE `ingles200h` DEFAULT CHARACTER SET = `utf8`;

USE `ingles200h`;

CREATE TABLE `propel_migration` (
  `version` int(11) DEFAULT \'0\'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `attributes`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `attributes_entity_type_id` INTEGER NOT NULL,
    `code` VARCHAR(45) NOT NULL,
    `frontend_type` enum(\'text\',\'textarea\',\'date\',\'boolean\',\'multiselect\',\'select\',\'price\') NOT NULL,
    `backend_type` enum(\'varchar\',\'int\',\'decimal\',\'text\',\'datetime\') NOT NULL,
    `validators` TEXT,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk-attributes-attributes_entity_types1_idx` (`attributes_entity_type_id`),
    CONSTRAINT `fk-attributes-attributes_entity_types1`
        FOREIGN KEY (`attributes_entity_type_id`)
        REFERENCES `attributes_entity_types` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `attributes_entity_types`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(100) NOT NULL,
    `table` VARCHAR(100) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `attributes_groups`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `order` INTEGER,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `attributes_options`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `attribute_id` INTEGER NOT NULL,
    `label` VARCHAR(255) NOT NULL,
    `value` VARCHAR(255) NOT NULL,
    `position` INTEGER NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk-attributes_options-attributes1_idx` (`attribute_id`),
    CONSTRAINT `fk-attributes_options-attributes1`
        FOREIGN KEY (`attribute_id`)
        REFERENCES `attributes` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `attributes_relations`
(
    `attributes_group_id` INTEGER NOT NULL,
    `attribute_id` INTEGER NOT NULL,
    `order` INTEGER,
    PRIMARY KEY (`attributes_group_id`,`attribute_id`),
    INDEX `fk-attributes_relations-attributes1_idx` (`attribute_id`),
    CONSTRAINT `fk-attributes_relations-attributes_groups1`
        FOREIGN KEY (`attributes_group_id`)
        REFERENCES `attributes_groups` (`id`),
    CONSTRAINT `fk-attributes_relations-attributes1`
        FOREIGN KEY (`attribute_id`)
        REFERENCES `attributes` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `attributes_sets`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `attributes_entity_type_id` INTEGER NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `default` enum(\'yes\',\'no\') NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk-attributes_sets-attributes_entity_types1_idx` (`attributes_entity_type_id`),
    CONSTRAINT `fk-attributes_sets-attributes_entity_types1`
        FOREIGN KEY (`attributes_entity_type_id`)
        REFERENCES `attributes_entity_types` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `attributes_value_datetime`
(
    `attribute_id` INTEGER NOT NULL,
    `entity_id` INTEGER NOT NULL,
    `value` DATETIME,
    PRIMARY KEY (`attribute_id`),
    CONSTRAINT `fk-attributes_value_datetime-attributes1`
        FOREIGN KEY (`attribute_id`)
        REFERENCES `attributes` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `attributes_value_decimal`
(
    `attribute_id` INTEGER NOT NULL,
    `entity_id` INTEGER NOT NULL,
    `value` DECIMAL(12,4),
    PRIMARY KEY (`attribute_id`,`entity_id`),
    CONSTRAINT `fk-attributes_value_decimal-attributes1`
        FOREIGN KEY (`attribute_id`)
        REFERENCES `attributes` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `attributes_value_int`
(
    `attribute_id` INTEGER NOT NULL,
    `entity_id` INTEGER NOT NULL,
    `value` INTEGER,
    PRIMARY KEY (`attribute_id`,`entity_id`),
    CONSTRAINT `fk-attributes_value_int-attributes1`
        FOREIGN KEY (`attribute_id`)
        REFERENCES `attributes` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `attributes_value_text`
(
    `attribute_id` INTEGER NOT NULL,
    `entity_id` INTEGER NOT NULL,
    `value` TEXT,
    PRIMARY KEY (`attribute_id`,`entity_id`),
    CONSTRAINT `fk-attributes_value_text-attributes1`
        FOREIGN KEY (`attribute_id`)
        REFERENCES `attributes` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `attributes_value_varchar`
(
    `attribute_id` INTEGER NOT NULL,
    `entity_id` INTEGER NOT NULL,
    `value` VARCHAR(255),
    PRIMARY KEY (`attribute_id`,`entity_id`),
    CONSTRAINT `fk-attributes_value_varchar-attributes1`
        FOREIGN KEY (`attribute_id`)
        REFERENCES `attributes` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `categories`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `attributes_set_id` INTEGER NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk-categories-attributes_sets1_idx` (`attributes_set_id`),
    CONSTRAINT `fk-categories-attributes_sets1`
        FOREIGN KEY (`attributes_set_id`)
        REFERENCES `attributes_sets` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `commissions`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `payment_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `level` INTEGER NOT NULL,
    `value` DECIMAL(10,2) NOT NULL,
    `paid` enum(\'yes\',\'no\') DEFAULT \'no\' NOT NULL,
    `active` enum(\'yes\',\'no\') DEFAULT \'yes\' NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk-commissions-users-idx` (`user_id`),
    INDEX `fk-commissions-payments-idx` (`payment_id`),
    CONSTRAINT `fk-commissions-users`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `fk-commissions-payments`
        FOREIGN KEY (`payment_id`)
        REFERENCES `payments` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `employees`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `attributes_set_id` INTEGER NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk-employees-attributes_sets1_idx` (`attributes_set_id`),
    CONSTRAINT `fk-employees-attributes_sets1`
        FOREIGN KEY (`attributes_set_id`)
        REFERENCES `attributes_sets` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `orders`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk-orders-users-idx` (`user_id`),
    CONSTRAINT `fk-orders-users`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `orders_items`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `order_id` INTEGER NOT NULL,
    `products_version_id` INTEGER NOT NULL,
    `qty` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `uq-orders_items-product_versions` (`order_id`, `products_version_id`),
    INDEX `fk-orders_items-orders-idx` (`order_id`),
    INDEX `fk-orders_items-products_versions-idx` (`products_version_id`),
    CONSTRAINT `fk-orders_items-orders`
        FOREIGN KEY (`order_id`)
        REFERENCES `orders` (`id`),
    CONSTRAINT `fk-orders_items-products_versions`
        FOREIGN KEY (`products_version_id`)
        REFERENCES `products_versions` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `payments`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `order_id` INTEGER NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk-payments-orders-idx` (`order_id`),
    CONSTRAINT `fk-payments-orders`
        FOREIGN KEY (`order_id`)
        REFERENCES `orders` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `producers`
(
    `user_id` INTEGER NOT NULL,
    `attributes_set_id` INTEGER NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`user_id`),
    INDEX `fk-producers-users-idx` (`user_id`),
    INDEX `fk-producers-attributes_sets1_idx` (`attributes_set_id`),
    CONSTRAINT `fk-producers-users`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `fk-producers-attributes_sets1`
        FOREIGN KEY (`attributes_set_id`)
        REFERENCES `attributes_sets` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `products`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `producer_id` INTEGER NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    `deleted_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fk-products-producers-idx` (`producer_id`),
    CONSTRAINT `fk-products-producers`
        FOREIGN KEY (`producer_id`)
        REFERENCES `producers` (`user_id`)
) ENGINE=InnoDB;

CREATE TABLE `products_categories`
(
    `products_id` INTEGER NOT NULL,
    `categories_id` INTEGER NOT NULL,
    PRIMARY KEY (`products_id`,`categories_id`),
    INDEX `fk-products_categories-categories1_idx` (`categories_id`),
    INDEX `fk-products_categories-products1_idx` (`products_id`),
    CONSTRAINT `fk-products_categories-products1`
        FOREIGN KEY (`products_id`)
        REFERENCES `products` (`id`),
    CONSTRAINT `fk-products_categories-categories1`
        FOREIGN KEY (`categories_id`)
        REFERENCES `categories` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `products_versions`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `attributes_set_id` INTEGER NOT NULL,
    `product_id` INTEGER NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk-products_versions-products-idx` (`product_id`),
    INDEX `fk-products_versions-attributes_sets1_idx` (`attributes_set_id`),
    CONSTRAINT `fk-products_versions-products`
        FOREIGN KEY (`product_id`)
        REFERENCES `products` (`id`),
    CONSTRAINT `fk-products_versions-attributes_sets1`
        FOREIGN KEY (`attributes_set_id`)
        REFERENCES `attributes_sets` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `products_versions_mlm`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `products_version_id` INTEGER NOT NULL,
    `type` enum(\'first\',\'recurrent\') NOT NULL,
    `level` INTEGER NOT NULL,
    `value` DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `index3` (`products_version_id`, `level`, `type`),
    INDEX `fk-products_versions_mlm-products_versions1_idx` (`products_version_id`),
    CONSTRAINT `fk-products_versions_mlm-products_versions1`
        FOREIGN KEY (`products_version_id`)
        REFERENCES `products_versions` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `sales_carts`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `users`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `attributes_set_id` INTEGER NOT NULL,
    `user_id` INTEGER,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    `deleted_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `fk-users-users-idx` (`user_id`),
    INDEX `fk-users-attributes_sets1_idx` (`attributes_set_id`),
    CONSTRAINT `fk-users-users`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `fk-users-attributes_sets1`
        FOREIGN KEY (`attributes_set_id`)
        REFERENCES `attributes_sets` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `seed_migration`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `namespace` VARCHAR(255) NOT NULL,
    `version` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'ingles200h' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `attributes`;

DROP TABLE IF EXISTS `attributes_entity_types`;

DROP TABLE IF EXISTS `attributes_groups`;

DROP TABLE IF EXISTS `attributes_options`;

DROP TABLE IF EXISTS `attributes_relations`;

DROP TABLE IF EXISTS `attributes_sets`;

DROP TABLE IF EXISTS `attributes_value_datetime`;

DROP TABLE IF EXISTS `attributes_value_decimal`;

DROP TABLE IF EXISTS `attributes_value_int`;

DROP TABLE IF EXISTS `attributes_value_text`;

DROP TABLE IF EXISTS `attributes_value_varchar`;

DROP TABLE IF EXISTS `categories`;

DROP TABLE IF EXISTS `commissions`;

DROP TABLE IF EXISTS `employees`;

DROP TABLE IF EXISTS `orders`;

DROP TABLE IF EXISTS `orders_items`;

DROP TABLE IF EXISTS `payments`;

DROP TABLE IF EXISTS `producers`;

DROP TABLE IF EXISTS `products`;

DROP TABLE IF EXISTS `products_categories`;

DROP TABLE IF EXISTS `products_versions`;

DROP TABLE IF EXISTS `products_versions_mlm`;

DROP TABLE IF EXISTS `sales_carts`;

DROP TABLE IF EXISTS `users`;

DROP TABLE IF EXISTS `seed_migration`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}