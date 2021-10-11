<?php

namespace Migrations;

use App\Orm\Repositories\AccessRightNameRepository;
use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1633977741InsertSubscriptionRightNames
 *
 * @package Migrations
 */
final class Migration1633977741InsertSubscriptionRightNames extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('access_right_names');

        $schema->insertRecords(['id', 'name'], ...[
            [11, AccessRightNameRepository::CREATE_SUBSCRIPTION],
            [12, AccessRightNameRepository::UPDATE_SUBSCRIPTION],
            [13, AccessRightNameRepository::REMOVE_SUBSCRIPTION]
        ]);

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

    

    }

}