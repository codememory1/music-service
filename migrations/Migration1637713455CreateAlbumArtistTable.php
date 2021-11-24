<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1637713455CreateAlbumArtistTable
 *
 * @package Migrations
 */
final class Migration1637713455CreateAlbumArtistTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `album_artists` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`album_id` INT NOT NULL,`user_id` INT NOT NULL);ALTER TABLE `album_artists` ADD FOREIGN KEY (`album_id`) REFERENCES albums(`id`) ON DELETE CASCADE;ALTER TABLE `album_artists` ADD FOREIGN KEY (`user_id`) REFERENCES users(`id`) ON DELETE CASCADE');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `album_artists`');

    }

}