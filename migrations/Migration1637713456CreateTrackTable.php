<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1637713456CreateTrackTable
 *
 * @package Migrations
 */
final class Migration1637713456CreateTrackTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `tracks` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`hash` VARCHAR(255) NOT NULL,`name` VARCHAR(255) NOT NULL,`category_id` INT NOT NULL,`image` VARCHAR(255) NOT NULL,`text` TEXT NULL DEFAULT NULL,`album_id` INT NOT NULL,`duration_time` BIGINT NOT NULL,`foul_language` TINYINT(1) NOT NULL DEFAULT 0,`created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,`updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP);ALTER TABLE `tracks` ADD FOREIGN KEY (`category_id`) REFERENCES track_categories(`id`) ON DELETE CASCADE;ALTER TABLE `tracks` ADD FOREIGN KEY (`album_id`) REFERENCES albums(`id`) ON DELETE CASCADE');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `tracks`');

    }

}