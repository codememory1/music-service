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

        $schema->addSql('CREATE TABLE IF NOT EXISTS `user_sessions` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`userid` INT NOT NULL,`refresh_token` TEXT NOT NULL,`ip` VARCHAR(32) NOT NULL,`country` VARCHAR(100) NULL DEFAULT NULL,`code_country` TINYTEXT NULL DEFAULT NULL,`region` VARCHAR(100) NULL DEFAULT NULL,`city` VARCHAR(100) NULL DEFAULT NULL,`latitude` FLOAT NULL DEFAULT NULL,`longitude` FLOAT NULL DEFAULT NULL,`valid_to` DATETIME NOT NULL)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `user_sessions`');

    }

}