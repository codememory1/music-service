<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1632837452CreateUserTable
 *
 * @package Migrations
 */
final class Migration1632837452CreateUserTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `users` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` VARCHAR(32) NOT NULL,`email` VARCHAR(255) NOT NULL,`username` VARCHAR(255) NOT NULL,`password` TEXT NOT NULL,`surname` VARCHAR(32) NULL DEFAULT NULL,`patronymic` VARCHAR(32) NULL DEFAULT NULL,`birth` DATE NULL DEFAULT NULL,`subscription_id` BIGINT UNSIGNED NULL DEFAULT NULL,`role_id` BIGINT UNSIGNED NOT NULL DEFAULT 1,`status` TINYINT(2) NOT NULL DEFAULT 0,`created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,`updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('users');

        $schema->dropTable();

    }

}