<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220212225045 extends AbstractMigration
{

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE albums (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL COMMENT \'Album name\', photo LONGTEXT NOT NULL COMMENT \'Link to album photo\', tags JSON DEFAULT NULL COMMENT \'Album tags\', auditions INT NULL DEFAULT 0 COMMENT \'Number of full plays\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F4E2474FC54C8C93 (type_id), INDEX IDX_F4E2474F12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE albums ADD CONSTRAINT FK_F4E2474FC54C8C93 FOREIGN KEY (type_id) REFERENCES album_types (id)');
        $this->addSql('ALTER TABLE albums ADD CONSTRAINT FK_F4E2474F12469DE2 FOREIGN KEY (category_id) REFERENCES album_categories (id)');

    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {

        $this->addSql('DROP TABLE albums');
        $this->addSql('ALTER TABLE album_categories CHANGE title_translation_key title_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Album category translation key\'');
        $this->addSql('ALTER TABLE album_types CHANGE `key` `key` VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Unique album type\', CHANGE title_translation_key title_translation_key VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Type name translation key\'');
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
        $this->addSql('ALTER TABLE user_sessions CHANGE refresh_token refresh_token LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Refresh token to update the access token\', CHANGE ip ip VARCHAR(32) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'IP address of authorized user\', CHANGE country country VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Authorized user country\', CHANGE country_code country_code VARCHAR(3) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Country code in two letters\', CHANGE region region VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Authorized user region\', CHANGE city city VARCHAR(100) DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Authorized user city\', CHANGE valid valid VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Token lifetime in CronTime format\'');
        $this->addSql('ALTER TABLE user_subscriptions CHANGE valid_to valid_to VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Subscription duration in the format 30d 10m, etc.\'');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User unique mail\', CHANGE username username VARCHAR(250) NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'The default username is the truncated mail then the symbol @\', CHANGE password password LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'User password hash\'');

    }

}
