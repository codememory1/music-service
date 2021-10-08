<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1633599594CreateActivationTokenTable
 *
 * @package Migrations
 */
final class Migration1633599594CreateActivationTokenTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `activation_tokens` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`user_id` INT NOT NULL,`token` TEXT NOT NULL);ALTER TABLE `activation_tokens` ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES users(`id`) ON DELETE CASCADE');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `activation_tokens`');

    }

}