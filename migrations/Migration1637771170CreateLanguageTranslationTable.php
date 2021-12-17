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

        $schema->addSql('CREATE TABLE IF NOT EXISTS `language_translations` (`lang_id` BIGINT UNSIGNED NOT NULL,`translation_key_id` BIGINT UNSIGNED NOT NULL,`translation` TEXT NOT NULL);ALTER TABLE `language_translations` ADD CONSTRAINT `FK_LanguageTranslation_Language` FOREIGN KEY (`lang_id`) REFERENCES languages(`id`) ON DELETE CASCADE;ALTER TABLE `language_translations` ADD CONSTRAINT `FK_LanguageTranslation_TranslationKey` FOREIGN KEY (`translation_key_id`) REFERENCES translation_keys(`id`) ON DELETE CASCADE');

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('language_translations');

        $schema->dropForeign('FK_LanguageTranslation_Language');
        $schema->dropForeign('FK_LanguageTranslation_TranslationKey');

        $schema->dropTable();

    }

}