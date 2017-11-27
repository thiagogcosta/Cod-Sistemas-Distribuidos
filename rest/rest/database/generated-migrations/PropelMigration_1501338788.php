<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1501338788.
 * Generated on 2017-07-29 14:33:08 by vagrant
 */
class PropelMigration_1501338788
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

DROP TABLE IF EXISTS `commissions`;

DROP TABLE IF EXISTS `orders`;

DROP TABLE IF EXISTS `orders_items`;

DROP TABLE IF EXISTS `payments`;

DROP TABLE IF EXISTS `sales_carts`;

ALTER TABLE `categories`

  ADD `category_id` INTEGER NOT NULL AFTER `attributes_set_id`;

CREATE INDEX `fk-categories-categories1_idx` ON `categories` (`category_id`);

ALTER TABLE `categories` ADD CONSTRAINT `fk-categories-categories1`
    FOREIGN KEY (`category_id`)
    REFERENCES `categories` (`id`);

CREATE TABLE `sales_commissions`
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
        REFERENCES `sales_payments` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `sales_orders`
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

CREATE TABLE `sales_orders_items`
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
        REFERENCES `sales_orders` (`id`),
    CONSTRAINT `fk-orders_items-products_versions`
        FOREIGN KEY (`products_version_id`)
        REFERENCES `products_versions` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `sales_payments`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `order_id` INTEGER NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk-payments-orders-idx` (`order_id`),
    CONSTRAINT `fk-payments-orders`
        FOREIGN KEY (`order_id`)
        REFERENCES `sales_orders` (`id`)
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

DROP TABLE IF EXISTS `sales_commissions`;

DROP TABLE IF EXISTS `sales_orders`;

DROP TABLE IF EXISTS `sales_orders_items`;

DROP TABLE IF EXISTS `sales_payments`;

ALTER TABLE `categories` DROP FOREIGN KEY `fk-categories-categories1`;

DROP INDEX `fk-categories-categories1_idx` ON `categories`;

ALTER TABLE `categories`

  DROP `category_id`;

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

CREATE TABLE `sales_carts`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}