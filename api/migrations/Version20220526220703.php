<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220526220703 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE password_resets_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE password_resets (id INT NOT NULL, user_id INT NOT NULL, code INT NOT NULL, status VARCHAR(255) NOT NULL, ttl CHAR(10) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9EDAFEA1A76ED395 ON password_resets (user_id)');
        $this->addSql('COMMENT ON COLUMN password_resets.code IS \'6-digit password change code\'');
        $this->addSql('COMMENT ON COLUMN password_resets.status IS \'One of the PasswordResetStatusEnum statuses\'');
        $this->addSql('COMMENT ON COLUMN password_resets.ttl IS \'Code lifetime in CronTime format\'');
        $this->addSql('COMMENT ON COLUMN password_resets.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN password_resets.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE password_resets ADD CONSTRAINT FK_9EDAFEA1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE users ALTER password TYPE TEXT');
        $this->addSql('ALTER TABLE users ALTER password DROP DEFAULT');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE password_resets_id_seq CASCADE');
        $this->addSql('DROP TABLE password_resets');
        $this->addSql('ALTER TABLE users ALTER password TYPE TEXT');
        $this->addSql('ALTER TABLE users ALTER password DROP DEFAULT');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
    }
}
