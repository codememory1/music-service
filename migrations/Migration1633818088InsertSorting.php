<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1633818088InsertSorting
 *
 * @package Migrations
 */
final class Migration1633818088InsertSorting extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('sorting');

        $schema->insertRecords(['table', 'columns'], ...[
            [
                'playlists',
                json_encode([
                    'name', 'created_at'
                ])
            ],
            [
                'subscriptions',
                json_encode([
                    'name', 'old_price', 'price', 'created_at'
                ])
            ],
            [
                'users',
                json_encode([
                    'id', 'birth', 'subscription_id', 'role_id',
                    'status', 'created_at', 'updated_at'
                ])
            ],
            [
                'user_sessions',
                json_encode([
                    'id', 'valid_to'
                ])
            ]
        ]);

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('sorting');

        $schema->deleteRecords();

    }

}