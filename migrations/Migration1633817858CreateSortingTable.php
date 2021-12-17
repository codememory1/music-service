<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1633817858CreateSortingTable
 *
 * @package Migrations
 */
final class Migration1633817858CreateSortingTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `sorting` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,`table` VARCHAR(64) NOT NULL UNIQUE,`columns` JSON NOT NULL)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('sorting');

        $schema->dropTable();

    }

}