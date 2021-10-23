<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1634237180CreatePasswordResetTable
 *
 * @package Migrations
 */
final class Migration1634237180CreatePasswordResetTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `password_resets` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`user_id` INT NOT NULL UNIQUE,`code` VARCHAR(6) NOT NULL,`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP);ALTER TABLE `password_resets` ADD CONSTRAINT `password_resets_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES users(`id`) ON DELETE CASCADE');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `password_resets`');

    }

}