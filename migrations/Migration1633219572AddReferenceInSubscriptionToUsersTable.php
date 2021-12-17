<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;
use Codememory\Components\Database\Schema\Interfaces\ReferenceDefinitionInterface;
use Codememory\Components\Database\Schema\StatementComponents\Reference;
use Codememory\Components\Database\Schema\StatementComponents\ReferenceDefinition;

/**
 * Class Migration1633219572AddReferenceInSubscriptionToUsersTable
 *
 * @package Migrations
 */
final class Migration1633219572AddReferenceInSubscriptionToUsersTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('users');

        $reference = new Reference();
        $reference->add(function (ReferenceDefinitionInterface $definition) {
            $definition
                ->constraint('FK_User_Subscription')
                ->table('subscriptions')
                ->foreignKeys('subscription_id')
                ->internalKeys('id')
                ->onDelete(ReferenceDefinition::RD_SET_NULL);
        });

        $schema->addToTable()->addReference($reference);

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('users');

        $schema->dropForeign('FK_User_Subscription');

    }

}