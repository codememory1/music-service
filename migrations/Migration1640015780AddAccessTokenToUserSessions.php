<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;
use Codememory\Components\Database\Schema\Interfaces\ColumnInterface;

/**
 * Class Migration1640015780AddAccessTokenToUserSessions
 *
 * @package Migrations
 */
final class Migration1640015780AddAccessTokenToUserSessions extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('user_sessions');

        $schema->addColumn(function (ColumnInterface $column) {
            $column
                ->setColumnName('access_token')
                ->text()
                ->notNull()
                ->after('refresh_token');
        });

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('user_sessions');

        $schema->dropColumn('access_token');

    }

}