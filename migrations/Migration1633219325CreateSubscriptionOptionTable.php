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

        $schema->addSql('CREATE TABLE IF NOT EXISTS `subscription_options` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`option_name_id` INT NOT NULL,`subscription` INT NOT NULL);ALTER TABLE `subscription_options` ADD CONSTRAINT `option_name_id_fk` FOREIGN KEY (`option_name_id`) REFERENCES subscription_option_names(`id`) ON DELETE CASCADE;ALTER TABLE `subscription_options` ADD CONSTRAINT `subscription_fk` FOREIGN KEY (`subscription`) REFERENCES subscriptions(`id`) ON DELETE CASCADE');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `subscription_options`');

    }

}