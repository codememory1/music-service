<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208185154 extends AbstractMigration
{

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE languages CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE role_permission_names CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE role_permissions CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE roles CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE subscription_permission_names CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE subscription_permissions CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE subscriptions CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE translation_keys CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE translations CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_profile_covers CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_profile_photos CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_profiles CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_subscriptions CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE users CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');

    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {

        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE languages CHANGE code code VARCHAR(3) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Country code consisting of two to three characters\', CHANGE title title VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Language name\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE role_permission_names CHANGE `key` `key` VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'A unique key that can be used to check availability\', CHANGE title_translation_key title_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Rule name translation key\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE role_permissions CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE roles CHANGE `key` `key` VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Unique role key against which the role will be checked\', CHANGE title_translation_key title_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Role name translation key\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE subscription_permission_names CHANGE `key` `key` VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'The unique key of the rule by which access will be checked\', CHANGE title_translation_key title_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Rule name translation key\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE subscription_permissions CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE subscriptions CHANGE name_translation_key name_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Subscription name translation key\', CHANGE description_translation_key description_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Subscription description translation key\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE translation_keys CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'A unique key by which it will be possible to receive a transfer\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE translations CHANGE translation translation LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Translation of the key into the specified language\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_activation_tokens CHANGE valid valid VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Token lifetime in CronTime format\', CHANGE token token LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Account activation token\'');
        $this->addSql('ALTER TABLE user_profile_covers CHANGE cover cover LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Path to cover\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_profile_photos CHANGE photo photo LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Path to photography\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_profiles CHANGE name name VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User real name\', CHANGE surname surname VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User real surname\', CHANGE patronymic patronymic VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User real patronymic\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_sessions CHANGE refresh_token refresh_token LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Refresh token to update the access token\', CHANGE ip ip VARCHAR(32) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'IP address of authorized user\', CHANGE country country VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Authorized user country\', CHANGE country_code country_code VARCHAR(3) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Country code in two letters\', CHANGE region region VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Authorized user region\', CHANGE city city VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Authorized user city\', CHANGE valid valid VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Token lifetime in CronTime format\'');
        $this->addSql('ALTER TABLE user_subscriptions CHANGE valid_to valid_to VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Subscription duration in the format 30d 10m, etc.\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User unique mail\', CHANGE username username VARCHAR(250) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'The default username is the truncated mail then the symbol @\', CHANGE password password LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User password hash\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');

    }

}