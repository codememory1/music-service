<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1633219324CreateSubscriptionTable
 *
 * @package Migrations
 */
final class Migration1633219324CreateSubscriptionTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `subscriptions` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` VARCHAR(32) NOT NULL,`description` VARCHAR(255) NULL DEFAULT NULL,`old_price` DECIMAL(10,2) NULL DEFAULT NULL,`price` DECIMAL(10,2) NOT NULL,`is_active` TINYINT(1) NOT NULL DEFAULT 0,`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('subscriptions');

        $schema->dropTable();

    }

}