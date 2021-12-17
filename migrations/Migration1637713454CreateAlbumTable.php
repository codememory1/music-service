<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1637713454CreateAlbumTable
 *
 * @package Migrations
 */
final class Migration1637713454CreateAlbumTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `albums` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` VARCHAR(255) NOT NULL,`type_id` BIGINT UNSIGNED NOT NULL,`created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,`updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP);ALTER TABLE `albums` ADD CONSTRAINT `FK_Album_AlbumType` FOREIGN KEY (`type_id`) REFERENCES album_types(`id`) ON DELETE CASCADE');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('albums');

        $schema->dropForeign('FK_Album_AlbumType');

        $schema->dropTable();

    }

}