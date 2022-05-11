<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511203806 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE languages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE translation_keys_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE translations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE languages (id INT NOT NULL, code VARCHAR(5) NOT NULL, original_title VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A0D1537977153098 ON languages (code)');
        $this->addSql('COMMENT ON COLUMN languages.code IS \'Abbreviated language code\'');
        $this->addSql('COMMENT ON COLUMN languages.original_title IS \'Full name of a language in its own language\'');
        $this->addSql('COMMENT ON COLUMN languages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN languages.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE translation_keys (id INT NOT NULL, key VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_99ACE7778A90ABA9 ON translation_keys (key)');
        $this->addSql('COMMENT ON COLUMN translation_keys.key IS \'Unique key in group@name format\'');
        $this->addSql('COMMENT ON COLUMN translation_keys.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN translation_keys.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE translations (id INT NOT NULL, language_id INT NOT NULL, translation_key_id INT NOT NULL, translation TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C6B7DA8782F1BAF4 ON translations (language_id)');
        $this->addSql('CREATE INDEX IDX_C6B7DA87D07ED992 ON translations (translation_key_id)');
        $this->addSql('COMMENT ON COLUMN translations.translation IS \'Translation in the specified language\'');
        $this->addSql('COMMENT ON COLUMN translations.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN translations.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE translations ADD CONSTRAINT FK_C6B7DA8782F1BAF4 FOREIGN KEY (language_id) REFERENCES languages (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE translations ADD CONSTRAINT FK_C6B7DA87D07ED992 FOREIGN KEY (translation_key_id) REFERENCES translation_keys (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
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
        $this->addSql('ALTER TABLE translations DROP CONSTRAINT FK_C6B7DA8782F1BAF4');
        $this->addSql('ALTER TABLE translations DROP CONSTRAINT FK_C6B7DA87D07ED992');
        $this->addSql('DROP SEQUENCE languages_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE translation_keys_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE translations_id_seq CASCADE');
        $this->addSql('DROP TABLE languages');
        $this->addSql('DROP TABLE translation_keys');
        $this->addSql('DROP TABLE translations');
    }
}
