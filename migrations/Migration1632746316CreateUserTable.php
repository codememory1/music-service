<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1632746316CreateUsersTable
 *
 * @package Migrations
 */
final class Migration1632746316CreateUsersTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `users` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`userid` INT NOT NULL,`email` VARCHAR(255) NOT NULL,`username` VARCHAR(255) NOT NULL,`password` TEXT NOT NULL,`surname` VARCHAR(32) NULL DEFAULT NULL,`patronymic` VARCHAR(32) NULL DEFAULT NULL,`birth` DATE NULL DEFAULT NULL,`subscription` INT NULL DEFAULT NULL,`role` INT NOT NULL DEFAULT 1,`status` INT NOT NULL DEFAULT 0,`activation_token` TEXT NULL DEFAULT NULL,`created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,`updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP);ALTER TABLE `users` ADD CONSTRAINT `status_fk` FOREIGN KEY (`status`) REFERENCES roles(`id`)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `users`');

    }

}