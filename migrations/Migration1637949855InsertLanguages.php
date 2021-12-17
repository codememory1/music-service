<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1637949855InsertLanguages
 *
 * @package Migrations
 */
final class Migration1637949855InsertLanguages extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('languages');

        $schema->insertRecords(['id', 'lang_code'], ...[
            [1, 'ru'],
            [2, 'en'],
        ]);

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DELETE FROM `translation_keys` WHERE `id` <= 2');

    }

}