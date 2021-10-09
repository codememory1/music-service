<?php

namespace Migrations;

use App\Orm\Repositories\RoleRepository;
use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1633520483InsertRoles
 *
 * @package Migrations
 */
final class Migration1633520483InsertRoles extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('roles');

        $schema->insertRecords(['id', 'name'], ...[
            [1, RoleRepository::USER_ROLE],
            [2, RoleRepository::ADMIN_ROLE],
            [3, RoleRepository::DEV_ROLE],
            [4, RoleRepository::MUSIC_MANAGER_ROLE],
            [5, RoleRepository::SUPPORT_ROLE]
        ]);

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {
        

    }

}