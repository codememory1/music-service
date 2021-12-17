<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1633977924InsertSubscriptionRights
 *
 * @package Migrations
 */
final class Migration1633977924InsertSubscriptionRights extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('role_rights');

        $schema->insertRecords(['access_right_id', 'role_id'], ...[
            # Administrator
            [11, 2], [12, 2], [13, 2],

            # Developer
            [11, 3], [12, 3], [13, 3]
        ]);

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DELETE FROM `role_rights`');

    }

}