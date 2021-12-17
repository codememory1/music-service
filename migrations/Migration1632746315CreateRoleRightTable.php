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

        $schema->addSql('CREATE TABLE IF NOT EXISTS `role_rights` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`access_right_id` BIGINT UNSIGNED NOT NULL,`role_id` BIGINT UNSIGNED NOT NULL);ALTER TABLE `role_rights` ADD CONSTRAINT `FK_RoleRight_AccessRightName` FOREIGN KEY (`access_right_id`) REFERENCES access_right_names(`id`) ON DELETE CASCADE;ALTER TABLE `role_rights` ADD CONSTRAINT `FK_RoleRight_Role` FOREIGN KEY (`role_id`) REFERENCES roles(`id`) ON DELETE CASCADE');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('role_rights');

        $schema->dropForeign('FK_RoleRight_AccessRightName');
        $schema->dropForeign('FK_RoleRight_Role');

        $schema->dropTable();

    }

}