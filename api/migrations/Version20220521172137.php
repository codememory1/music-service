<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220521172137 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE account_activation_codes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_profiles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_sessions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE account_activation_codes (id INT NOT NULL, user_id INT NOT NULL, code INT NOT NULL, ttl CHAR(10) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6DC85EC9A76ED395 ON account_activation_codes (user_id)');
        $this->addSql('COMMENT ON COLUMN account_activation_codes.code IS \'A six-digit code to activate your account\'');
        $this->addSql('COMMENT ON COLUMN account_activation_codes.ttl IS \'Code lifetime in CronTime format\'');
        $this->addSql('COMMENT ON COLUMN account_activation_codes.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN account_activation_codes.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_profiles (id INT NOT NULL, user_id INT NOT NULL, pseudonym VARCHAR(40) NOT NULL, date_birth TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6BBD6130A76ED395 ON user_profiles (user_id)');
        $this->addSql('COMMENT ON COLUMN user_profiles.pseudonym IS \'Account pseudonym\'');
        $this->addSql('COMMENT ON COLUMN user_profiles.date_birth IS \'User date of birth(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_profiles.photo IS \'Photo as path s3 storage\'');
        $this->addSql('COMMENT ON COLUMN user_profiles.status IS \'One of the UserProfileStatusEnum statuses\'');
        $this->addSql('COMMENT ON COLUMN user_profiles.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_profiles.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_sessions (id INT NOT NULL, user_id INT NOT NULL, type VARCHAR(255) NOT NULL, access_token TEXT DEFAULT NULL, refresh_token TEXT DEFAULT NULL, is_active BOOLEAN DEFAULT NULL, ip VARCHAR(50) DEFAULT NULL, browser VARCHAR(50) DEFAULT NULL, device VARCHAR(25) DEFAULT NULL, operating_system VARCHAR(25) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, coordinates TEXT NOT NULL, last_activity TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7AED7913A76ED395 ON user_sessions (user_id)');
        $this->addSql('COMMENT ON COLUMN user_sessions.type IS \'Session type from UserSessionTypeEnum enumeration\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.access_token IS \'Access Token for which access will be provided\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.refresh_token IS \'Refresh Token for refreshing Access Token and for getting session information\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.is_active IS \'Is the session active now\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.ip IS \'The IP address from which the account was logged out or registered\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.browser IS \'The browser from which the account was logged out or registered\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.device IS \'The model of the device from which the account was logged out or registered\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.operating_system IS \'The operating system of the device from which the account was logged out or registered\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.city IS \'The city in which the account was logged out or registered\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.country IS \'The country in which the account was logged out or registered\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.coordinates IS \'The authority in which the account was logged out or registered(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.last_activity IS \'Date of last activity on the account(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, role_id INT NOT NULL, email VARCHAR(255) NOT NULL, password TEXT NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE INDEX IDX_1483A5E9D60322AC ON users (role_id)');
        $this->addSql('COMMENT ON COLUMN users.email IS \'Email to login\'');
        $this->addSql('COMMENT ON COLUMN users.password IS \'Password as secure hash\'');
        $this->addSql('COMMENT ON COLUMN users.status IS \'One of the UserStatusEnum statuses\'');
        $this->addSql('COMMENT ON COLUMN users.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN users.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE account_activation_codes ADD CONSTRAINT FK_6DC85EC9A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_profiles ADD CONSTRAINT FK_6BBD6130A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_sessions ADD CONSTRAINT FK_7AED7913A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9D60322AC FOREIGN KEY (role_id) REFERENCES roles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_activation_codes DROP CONSTRAINT FK_6DC85EC9A76ED395');
        $this->addSql('ALTER TABLE user_profiles DROP CONSTRAINT FK_6BBD6130A76ED395');
        $this->addSql('ALTER TABLE user_sessions DROP CONSTRAINT FK_7AED7913A76ED395');
        $this->addSql('DROP SEQUENCE account_activation_codes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_profiles_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_sessions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP TABLE account_activation_codes');
        $this->addSql('DROP TABLE user_profiles');
        $this->addSql('DROP TABLE user_sessions');
        $this->addSql('DROP TABLE users');
    }
}
