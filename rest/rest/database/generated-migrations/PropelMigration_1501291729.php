<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1501291728.
 * Generated on 2017-07-29 01:28:48 by vagrant
 */
class PropelMigration_1501291729
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

ALTER TABLE `attributes_groups` ADD `attributes_set_id` INT NOT NULL;
ALTER TABLE `attributes_groups` ADD CONSTRAINT `fk_attributes_groups_set` FOREIGN KEY (attributes_set_id) REFERENCES attributes_sets(id);

ALTER TABLE `attributes` CHANGE `frontend_type` `frontend_type` ENUM(\'text\',\'textarea\',\'date\',\'boolean\',\'multiselect\',\'select\',\'price\', \'password\', \'email\') NOT NULL;

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

ALTER TABLE `attributes_groups`
    DROP INDEX `fk_attributes_groups_set`;

    ALTER TABLE `attributes_groups`
DROP COLUMN `attributes_set_id`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}