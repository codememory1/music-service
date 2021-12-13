<?php

namespace Migrations;

use Codememory\Components\Database\Migrations\AbstractMigration;
use Codememory\Components\Database\Migrations\Interfaces\SchemaInterface as MigrationSchemaInterface;

/**
 * Class Migration1637949838InsertTranslationKeys
 *
 * @package Migrations
 */
final class Migration1637949838InsertTranslationKeys extends AbstractMigration
{

    /**
     * @inheritDoc
     */
    public function up(MigrationSchemaInterface $schema): void
    {

        $schema->selectTable('translation_keys');

        $schema->insertRecords(['id', 'key'], ...[
            [1, 'register@nameIsRequired'],
            [2, 'register@nameLengthRange'],
            [3, 'register@accountWithEmailExist'],
            [4, 'register@successRegister'],
            [5, 'register@invalidPassword'],
            [6, 'security@samePassword'],
            [7, 'security@minPassword'],
            [8, 'security@invalidTokenActivation'],
            [9, 'security@successAccountActivation'],
            [10, 'security@passwordIsRequired'],
            [11, 'security@invalidRole'],
            [12, 'security@notAuth'],
            [13, 'security@wrongPassword'],
            [14, 'auth@loginIsRequired'],
            [15, 'auth@badIdentification'],
            [16, 'auth@emailNotActivate'],
            [17, 'auth@successAuth'],
            [18, 'playlist@nameLengthRange'],
            [19, 'playlist@temporaryFormat'],
            [20, 'playlist@exist'],
            [21, 'playlist@successCreate'],
            [22, 'playlist@successUpdate'],
            [23, 'playlist@successDelete'],
            [24, 'subscription@nameIsRequired'],
            [25, 'subscription@priceInTypeNumber'],
            [26, 'subscription@invalidStatusActivation'],
            [27, 'subscription@successCreate'],
            [28, 'subscription@successUpdate'],
            [29, 'subscription@successDelete'],
            [30, 'passwordRecovery@withoutAuth'],
            [31, 'passwordRecovery@successRestoreRequest'],
            [32, 'passwordRecovery@invalidCode'],
            [33, 'passwordRecovery@successRecovery'],
            [34, 'translation@langIsRequired'],
            [35, 'translation@translationKeyIsRequired'],
            [36, 'translation@translationKeyMaxLength'],
            [37, 'translation@translationIsRequired'],
            [38, 'translation@successCreateLang'],
            [39, 'translation@langExist'],
            [40, 'translation@langNotExist'],
            [41, 'translation@translationExist'],
            [42, 'translation@successAddTranslation'],
            [43, 'translation@successUpdateCache'],
            [44, 'common@invalidEmail'],
            [45, 'common@userNotExist'],
            [46, 'common@userExist'],
            [47, 'subscription@activeInTypeBoolean'],
            [48, 'playlist@notExist'],
            [49, 'subscription@notExist'],
            [50, 'confirmRegistration'],
            [51, 'passwordRecovery'],
            [52, 'track@nameIsRequired'],
            [53, 'track@nameMaxLength'],
            [54, 'track@categoryIsRequired'],
            [55, 'track@imageIsRequired'],
            [56, 'track@albumIsRequired'],
            [57, 'track@durationTimeIsRequired'],
            [58, 'track@durationTimeInTypeInteger'],
            [59, 'track@foulLanguageIsRequired'],
            [60, 'album@notExist'],
            [61, 'album@exist'],
            [62, 'trackCategory@exist'],
            [63, 'trackCategory@notExist'],
            [64, 'track@successAdd'],
            [65, 'common@invalidImageType'],
            [66, 'track@numberOfImages'],
            [67, 'track@notExist'],
            [68, 'track@successDelete'],
            [69, 'track@textIsRequired'],
            [70, 'track@successAddText'],
            [71, 'common@invalidRefreshToken'],
            [72, 'refreshToken@successRefreshAccessToken'],
            [73, 'track@invalidSubtitlesType'],
            [74, 'track@invalidFormatSubtitles'],
            [75, 'track@dublicateLabels'],
            [76, 'track@successAddSubtitles'],
            [77, 'track@numberSubtitleFiles'],
            [78, 'track@subtitleMimeType'],
            [79, 'track@subtitleExtension'],
            [80, 'track@subtitleManualIsRequired'],
            [81, 'track@subtitleInvalidFormat'],
        ]);

    }

    /**
     * @inheritDoc
     */
    public function down(MigrationSchemaInterface $schema): void
    {

        $schema->addSql('DELETE FROM `translation_keys` WHERE `id` <= 81');

    }

}