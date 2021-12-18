<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1632941679CreateUserSessionTable
 *
 * @package Migrations
 */
final class Migration1632941679CreateUserSessionTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `user_sessions` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`user_id` BIGINT UNSIGNED NOT NULL,`refresh_token` TEXT NOT NULL,`ip` VARCHAR(32) NOT NULL,`country` VARCHAR(100) NULL DEFAULT NULL,`code_country` TINYTEXT NULL DEFAULT NULL,`region` VARCHAR(100) NULL DEFAULT NULL,`city` VARCHAR(100) NULL DEFAULT NULL,`latitude` FLOAT NULL DEFAULT NULL,`longitude` FLOAT NULL DEFAULT NULL,`valid_to` DATETIME NOT NULL)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('user_sessions');

        $schema->dropTable();

    }

}