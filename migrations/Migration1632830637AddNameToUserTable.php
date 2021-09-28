<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;
use Codememory\Components\Database\Schema\Interfaces\ColumnInterface;

/**
 * Class Migration1632830637AddNameToUserTable
 *
 * @package Migrations
 */
final class Migration1632830637AddNameToUserTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('users');

        $schema->addColumn(function (ColumnInterface $column) {
            $column
                ->setColumnName('name')
                ->varchar(32)
                ->notNull()
                ->after('userid');
        });

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('users');

        $schema->dropColumn('name');

    }

}