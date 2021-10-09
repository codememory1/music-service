<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;
use Codememory\Components\Database\Schema\Interfaces\ColumnInterface;
use Codememory\Components\Database\Schema\Interfaces\ReferenceDefinitionInterface;
use Codememory\Components\Database\Schema\StatementComponents\Reference;
use Codememory\Components\Database\Schema\StatementComponents\ReferenceDefinition;

/**
 * Class Migration1633767948ChangeFieldUseridToUserSessionsTable
 *
 * @package Migrations
 */
final class Migration1633767948ChangeFieldUseridToUserSessionsTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('user_sessions');

        $schema->dropColumn('userid');
        $schema->addColumn(function (ColumnInterface $column) {
            $column->setColumnName('user_id')
                ->int()
                ->notNull()
                ->after('id');
        });

        $reference = new Reference();
        $reference->add(function (ReferenceDefinitionInterface $definition) {
            $definition
                ->constraint('user_sessions_user_id_fk')
                ->foreignKeys('user_id')
                ->table('users')
                ->internalKeys('id')
                ->onDelete(ReferenceDefinition::RD_CASCADE);
        });

        $schema->addToTable()->addReference($reference);

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {


        $schema->selectTable('user_sessions');

        $schema->dropForeign('user_sessions_user_id');

        $schema->dropColumn('user_id');
        $schema->addColumn(function (ColumnInterface $column) {
            $column->setColumnName('userid')->int()->notNull();
        });

    }

}