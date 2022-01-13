<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1637771170CreateLanguageTranslationTable
 *
 * @package Migrations
 */
final class Migration1637771170CreateLanguageTranslationTable extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('CREATE TABLE IF NOT EXISTS `language_translations` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, `lang_id` BIGINT UNSIGNED NOT NULL,`key` VARCHAR(255) NOT NULL,`translation` TEXT NOT NULL)');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('language_translations');

        $schema->dropTable();

    }

}