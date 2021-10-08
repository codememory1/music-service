<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;
use Codememory\Components\Database\Schema\Interfaces\ColumnInterface;

/**
 * Class Migration1633520482DeleteFiledAllowedToRoleRightsTable
 *
 * @package Migrations
 */
final class Migration1633520482DeleteFiledAllowedToRoleRightsTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('role_rights');

        $schema->dropColumn('allowed');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('role_rights');

        $schema->addColumn(function (ColumnInterface $column) {
            $column->setColumnName('allowed')
                ->tinyint(1)
                ->default(0);
        });

    }

}