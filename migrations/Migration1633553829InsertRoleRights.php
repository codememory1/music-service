<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1633553829InsertRoleRights
 *
 * @package Migrations
 */
final class Migration1633553829InsertRoleRights extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('role_rights');

        $schema->insertRecords(['access_right', 'role_id'], ...[
            # Administrator
            [1, 2], [5, 2], [6, 2], [7, 2],

            # Developer
            [1, 3], [2, 3], [3, 3], [4, 3],
            [5, 3], [6, 3], [7, 3], [8, 3],
            [9, 3], [10, 3], [11, 3], [12, 3],
            [13, 3], [14, 3], [15, 3], [16, 3],
            [17, 3],

            # Music Manager
            [2, 4], [4, 4]
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