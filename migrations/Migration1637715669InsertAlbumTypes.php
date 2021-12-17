<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;
use App\Orm\Repositories\AlbumTypeRepository;

/**
 * Class Migration1637715669InsertAlbumTypes
 *
 * @package Migrations
 */
final class Migration1637715669InsertAlbumTypes extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('album_types');

        $schema->insertRecords(['name'], ...[
            [AlbumTypeRepository::DEMO],
            [AlbumTypeRepository::DEBUT],
            [AlbumTypeRepository::JOINT],
        ]);

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DELETE FROM `album_types`');

    }

}