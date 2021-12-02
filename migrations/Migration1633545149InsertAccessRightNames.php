<?php

namespace Migrations;

use App\Orm\Repositories\AccessRightNameRepository;
use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1633545149InsertAccessRightNames
 *
 * @package Migrations
 */
final class Migration1633545149InsertAccessRightNames extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('access_right_names');

        $schema->insertRecords(['id', 'name'], ...[
            [1, AccessRightNameRepository::AUTH_TO_AP],
            [2, AccessRightNameRepository::ADD_MUSIC_FROM_AP],
            [3, AccessRightNameRepository::REMOVE_MUSIC_FROM_AP],
            [4, AccessRightNameRepository::CHANGE_MUSIC_FROM_AP],
            [5, AccessRightNameRepository::VIEW_USERS],
            [6, AccessRightNameRepository::EDIT_USER_DATA],
            [7, AccessRightNameRepository::VIEW_STATISTICS],
            [8, AccessRightNameRepository::ADD_MUSIC_AS_EXECUTOR],
            [9, AccessRightNameRepository::REMOVE_MUSIC_AS_EXECUTOR],
            [10, AccessRightNameRepository::CHANGE_MUSIC_AS_EXECUTOR],
            [11, AccessRightNameRepository::CREATE_SUBSCRIPTION],
            [12, AccessRightNameRepository::UPDATE_SUBSCRIPTION],
            [13, AccessRightNameRepository::REMOVE_SUBSCRIPTION],
            [14, AccessRightNameRepository::ADD_MUSIC],
            [15, AccessRightNameRepository::UPDATE_TRANSLATION_CACHE],
            [16, AccessRightNameRepository::CREATE_LANG],
            [17, AccessRightNameRepository::ADD_TRANSLATION]
        ]);

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DELETE FROM `access_right_names`');

    }

}