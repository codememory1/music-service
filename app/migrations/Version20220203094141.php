<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220203094141 extends AbstractMigration
{

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE user_sessions (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, refresh_token LONGTEXT NOT NULL COMMENT \'Refresh token to update the access token\', ip VARCHAR(32) NOT NULL COMMENT \'IP address of authorized user\', country VARCHAR(100) DEFAULT NULL COMMENT \'Authorized user country\', country_code VARCHAR(3) DEFAULT NULL COMMENT \'Country code in two letters\', region VARCHAR(100) DEFAULT NULL COMMENT \'Authorized user region\', city VARCHAR(100) DEFAULT NULL COMMENT \'Authorized user city\', latitude DOUBLE PRECISION DEFAULT NULL COMMENT \'Localization by X\', longitude DOUBLE PRECISION DEFAULT NULL COMMENT \'Localization by Y\', valid VARCHAR(10) NOT NULL COMMENT \'Token lifetime in CronTime format\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7AED7913A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_sessions ADD CONSTRAINT FK_7AED7913A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');

    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {

        $this->addSql('DROP TABLE user_sessions');
        $this->addSql('ALTER TABLE languages CHANGE code code VARCHAR(3) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Country code consisting of two to three characters\', CHANGE title title VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Language name\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE role_permission_names CHANGE `key` `key` VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'A unique key that can be used to check availability\', CHANGE title_translation_key title_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Rule name translation key\'');
        $this->addSql('ALTER TABLE roles CHANGE `key` `key` VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Unique role key against which the role will be checked\', CHANGE title_translation_key title_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Role name translation key\'');
        $this->addSql('ALTER TABLE subscription_permission_names CHANGE `key` `key` VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'The unique key of the rule by which access will be checked\', CHANGE title_translation_key title_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Rule name translation key\'');
        $this->addSql('ALTER TABLE subscriptions CHANGE name_translation_key name_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Subscription name translation key\', CHANGE description_translation_key description_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Subscription description translation key\'');
        $this->addSql('ALTER TABLE translation_keys CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'A unique key by which it will be possible to receive a transfer\'');
        $this->addSql('ALTER TABLE translations CHANGE translation translation LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Translation of the key into the specified language\'');
        $this->addSql('ALTER TABLE user_activation_tokens CHANGE valid valid VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Token lifetime in CronTime format\', CHANGE token token LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Account activation token\'');
        $this->addSql('ALTER TABLE user_profile_covers CHANGE cover cover LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Path to cover\'');
        $this->addSql('ALTER TABLE user_profile_photos CHANGE photo photo LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Path to photography\'');
        $this->addSql('ALTER TABLE user_profiles CHANGE name name VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User real name\', CHANGE surname surname VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User real surname\', CHANGE patronymic patronymic VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User real patronymic\'');
        $this->addSql('ALTER TABLE user_subscriptions CHANGE valid_to valid_to VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Subscription duration in the format 30d 10m, etc.\'');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User unique mail\', CHANGE username username VARCHAR(250) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'The default username is the truncated mail then the symbol @\', CHANGE password password LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User password hash\'');

    }

}
