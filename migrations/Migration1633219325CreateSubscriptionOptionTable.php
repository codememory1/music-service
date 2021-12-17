<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1633219325CreateSubscriptionOptionTable
 *
 * @package Migrations
 */
final class Migration1633219325CreateSubscriptionOptionTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `subscription_options` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`subscription_option_name_id` BIGINT UNSIGNED NOT NULL,`subscription_id` BIGINT UNSIGNED NOT NULL);ALTER TABLE `subscription_options` ADD FOREIGN KEY (`subscription_option_name_id`) REFERENCES subscription_option_names(`id`) ON DELETE CASCADE;ALTER TABLE `subscription_options` ADD CONSTRAINT `FK_SubscriptionOption_Subscription` FOREIGN KEY (`subscription_id`) REFERENCES subscriptions(`id`) ON DELETE CASCADE');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('subscription_options');

        $schema->dropForeign('FK_SubscriptionOption_Subscription');

        $schema->dropTable();

    }

}