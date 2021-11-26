<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1637771169CreateTranslationKeyTable
 *
 * @package Migrations
 */
final class Migration1637771169CreateTranslationKeyTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `translation_keys` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,`key` VARCHAR(64) NOT NULL UNIQUE)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DROP TABLE IF EXISTS `translation_keys`');

    }

}