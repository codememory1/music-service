<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1633219323CreateSubscriptionOptionNameTable
 *
 * @package Migrations
 */
final class Migration1633219323CreateSubscriptionOptionNameTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `subscription_option_names` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` VARCHAR(50) NOT NULL UNIQUE,`title` VARCHAR(255) NOT NULL)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `subscription_option_names`');

    }

}