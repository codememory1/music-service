<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;
use Codememory\Components\Database\Schema\Interfaces\ColumnInterface;

/**
 * Class Migration1633694999RemoveFieldUseridToUsersTable
 *
 * @package Migrations
 */
final class Migration1633694999RemoveFieldUseridToUsersTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('users');

        $schema->dropColumn('userid');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('users');

        $schema->addColumn(function (ColumnInterface $column) {
            $column->setColumnName('userid')->int();
        });

    }

}