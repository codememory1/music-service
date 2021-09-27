<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1632746314CreateRoleTable
 *
 * @package Migrations
 */
final class Migration1632746314CreateRoleTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `roles` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`name` VARCHAR(100) NOT NULL UNIQUE)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `roles`');

    }

}