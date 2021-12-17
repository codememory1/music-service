<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1637713452CreateAlbumTypeTable
 *
 * @package Migrations
 */
final class Migration1637713452CreateAlbumTypeTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `album_types` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` VARCHAR(32) NOT NULL,`created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,`updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('album_types');

        $schema->dropTable();

    }

}