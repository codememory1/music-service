<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1637713453CreateTrackCategoryTable
 *
 * @package Migrations
 */
final class Migration1637713453CreateTrackCategoryTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `track_categories` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`translation_key` VARCHAR(64) NOT NULL,`created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,`updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `track_categories`');

    }

}