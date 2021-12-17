<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1639266738CreateTrackSubtitleTable
 *
 * @package Migrations
 */
final class Migration1639266738CreateTrackSubtitleTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `track_subtitles` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`track_id` BIGINT UNSIGNED NOT NULL,`subtitles` JSON NOT NULL,`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,`updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP);ALTER TABLE `track_subtitles` ADD CONSTRAINT `FK_TrackSubtitle_Track` FOREIGN KEY (`track_id`) REFERENCES tracks(`id`) ON DELETE CASCADE');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('track_subtitles');

        $schema->dropForeign('FK_TrackSubtitle_Track');

        $schema->dropTable();

    }

}