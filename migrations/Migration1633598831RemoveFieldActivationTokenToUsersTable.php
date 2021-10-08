<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;
use Codememory\Components\Database\Schema\Interfaces\ColumnInterface;

/**
 * Class Migration1633598831RemoveFieldActivationTokenToUsersTable
 *
 * @package Migrations
 */
final class Migration1633598831RemoveFieldActivationTokenToUsersTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('users');

        $schema->dropColumn('activation_token');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('users');

        $schema->addColumn(function (ColumnInterface $column) {
            $column->setColumnName('activation_token')->text()->null()->default('NULL');
        });

    }

}