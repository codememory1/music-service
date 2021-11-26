<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1637771168CreateLanguageTable
 *
 * @package Migrations
 */
final class Migration1637771168CreateLanguageTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `languages` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`lang` VARCHAR(5) NOT NULL UNIQUE)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `languages`');

    }

}