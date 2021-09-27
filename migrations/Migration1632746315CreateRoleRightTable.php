<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1632746315CreateRoleRightTable
 *
 * @package Migrations
 */
final class Migration1632746315CreateRoleRightTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `role_rights` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`access_right` INT NOT NULL,`role_id` INT NOT NULL,`allowed` TINYINT(1) NOT NULL DEFAULT 0);ALTER TABLE `role_rights` ADD CONSTRAINT `access_right_fk` FOREIGN KEY (`access_right`) REFERENCES access_right_names(`id`) ON DELETE CASCADE;ALTER TABLE `role_rights` ADD CONSTRAINT `role_id_fk` FOREIGN KEY (`role_id`) REFERENCES roles(`id`) ON DELETE CASCADE');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `role_rights`');

    }

}