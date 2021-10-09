<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;
use Codememory\Components\Database\Schema\Interfaces\ColumnInterface;
use Codememory\Components\Database\Schema\Interfaces\ReferenceDefinitionInterface;
use Codememory\Components\Database\Schema\StatementComponents\Reference;
use Codememory\Components\Database\Schema\StatementComponents\ReferenceDefinition;

/**
 * Class Migration1633696701ChangeFieldUseridToPlaylistTable
 *
 * @package Migrations
 */
final class Migration1633696701ChangeFieldUseridToPlaylistTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('playlists');

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
                ->constraint('playlist_user_id_fk')
                ->foreignKeys('user_id')
                ->table('users')
                ->internalKeys('id')
                ->onUpdate(ReferenceDefinition::RD_CASCADE);
        });

        $schema->addToTable()->addReference($reference);

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('playlists');

        $schema->dropForeign('playlist_user_id');

        $schema->dropColumn('user_id');
        $schema->addColumn(function (ColumnInterface $column) {
            $column->setColumnName('userid')->int()->notNull();
        });

    }

}