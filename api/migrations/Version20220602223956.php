<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602223956 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE platform_settings_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE platform_settings (id INT NOT NULL, key VARCHAR(255) NOT NULL, value TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6035A0D78A90ABA9 ON platform_settings (key)');
        $this->addSql('COMMENT ON COLUMN platform_settings.key IS \'Unique setting key to receive\'');
        $this->addSql('COMMENT ON COLUMN platform_settings.value IS \'Setting value(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN platform_settings.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN platform_settings.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE password_resets ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE password_resets ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE password_resets ALTER ttl TYPE CHAR(10)');
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
        $this->addSql('DROP SEQUENCE platform_settings_id_seq CASCADE');
        $this->addSql('DROP TABLE platform_settings');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE password_resets ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE password_resets ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE password_resets ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE users ALTER password TYPE TEXT');
        $this->addSql('ALTER TABLE users ALTER password DROP DEFAULT');
    }
}
