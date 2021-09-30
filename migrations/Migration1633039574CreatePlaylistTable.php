<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1633039574CreatePlaylistTable
 *
 * @package Migrations
 */
final class Migration1633039574CreatePlaylistTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `playlists` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`userid` INT NOT NULL,`name` VARCHAR(100) NOT NULL,`reserved` TINYINT(1) NOT NULL DEFAULT 0,`temporary` DATETIME NULL DEFAULT NULL,`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,`updated_at` DATETIME NULL DEFAULT NULL)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `playlists`');

    }

}