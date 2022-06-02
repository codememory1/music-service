<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602095528 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE album_types_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE album_types (id INT NOT NULL, key VARCHAR(255) NOT NULL, title_translation_key VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F88C3168A90ABA9 ON album_types (key)');
        $this->addSql('COMMENT ON COLUMN album_types.key IS \'Unique key for identification\'');
        $this->addSql('COMMENT ON COLUMN album_types.title_translation_key IS \'Type name as a translation key\'');
        $this->addSql('COMMENT ON COLUMN album_types.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN album_types.updated_at IS \'(DC2Type:datetime_immutable)\'');
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
        $this->addSql('DROP SEQUENCE album_types_id_seq CASCADE');
        $this->addSql('DROP TABLE album_types');
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
