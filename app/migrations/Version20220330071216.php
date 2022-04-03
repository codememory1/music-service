<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330071216 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE albums ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE albums ADD CONSTRAINT FK_F4E2474FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_F4E2474FA76ED395 ON albums (user_id)');
        $this->addSql('ALTER TABLE subscriptions ADD `key` VARCHAR(50) NOT NULL COMMENT \'Key for check\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4778A018A90ABA9 ON subscriptions (`key`)');
        $this->addSql('ALTER TABLE user_activation_tokens DROP valid');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE album_categories CHANGE title_translation_key title_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Album category translation key\'');
        $this->addSql('ALTER TABLE album_types CHANGE `key` `key` VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Unique album type\', CHANGE title_translation_key title_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Type name translation key\'');
        $this->addSql('ALTER TABLE albums DROP FOREIGN KEY FK_F4E2474FA76ED395');
        $this->addSql('DROP INDEX IDX_F4E2474FA76ED395 ON albums');
        $this->addSql('ALTER TABLE albums DROP user_id, CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Album name\', CHANGE photo photo LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Link to album photo\'');
        $this->addSql('ALTER TABLE languages CHANGE code code VARCHAR(3) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Country code consisting of two to three characters\', CHANGE title title VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Language name\'');
        $this->addSql('ALTER TABLE media_library_events CHANGE name name VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE media_library_music_events CHANGE name name VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE music_ratings CHANGE type type VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE musics CHANGE type type VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE photo photo LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE full_text full_text LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE subtitles subtitles LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE password_resets CHANGE token token LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Password reset token\'');
        $this->addSql('ALTER TABLE playlist_directories CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE playlist_events CHANGE name name VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE playlists CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE role_permission_names CHANGE `key` `key` VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'A unique key that can be used to check availability\', CHANGE title_translation_key title_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Rule name translation key\'');
        $this->addSql('ALTER TABLE roles CHANGE `key` `key` VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Unique role key against which the role will be checked\', CHANGE title_translation_key title_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Role name translation key\'');
        $this->addSql('ALTER TABLE subscription_permission_names CHANGE `key` `key` VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'The unique key of the rule by which access will be checked\', CHANGE title_translation_key title_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Rule name translation key\'');
        $this->addSql('DROP INDEX UNIQ_4778A018A90ABA9 ON subscriptions');
        $this->addSql('ALTER TABLE subscriptions DROP `key`, CHANGE name_translation_key name_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Subscription name translation key\', CHANGE description_translation_key description_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Subscription description translation key\'');
        $this->addSql('ALTER TABLE translation_keys CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'A unique key by which it will be possible to receive a transfer\'');
        $this->addSql('ALTER TABLE translations CHANGE translation translation LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Translation of the key into the specified language\'');
        $this->addSql('ALTER TABLE user_activation_tokens ADD valid VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Token lifetime in CronTime format\', CHANGE token token LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Account activation token\'');
        $this->addSql('ALTER TABLE user_profile_covers CHANGE cover cover LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Path to cover\'');
        $this->addSql('ALTER TABLE user_profile_photos CHANGE photo photo LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Path to photography\'');
        $this->addSql('ALTER TABLE user_profiles CHANGE name name VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User real name\', CHANGE surname surname VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User real surname\', CHANGE patronymic patronymic VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User real patronymic\'');
        $this->addSql('ALTER TABLE user_sessions CHANGE refresh_token refresh_token LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Refresh token to update the access token\', CHANGE ip ip VARCHAR(32) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'IP address of authorized user\', CHANGE country country VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Authorized user country\', CHANGE country_code country_code VARCHAR(3) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Country code in two letters\', CHANGE region region VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Authorized user region\', CHANGE city city VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Authorized user city\', CHANGE device_model device_model VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE operating_system operating_system VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE browser browser VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user_subscriptions CHANGE valid_to valid_to VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Subscription duration in the format 30d 10m, etc.\'');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User unique mail\', CHANGE username username VARCHAR(250) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'The default username is the truncated mail then the symbol @\', CHANGE password password LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User password hash\'');
    }
}
