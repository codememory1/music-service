<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220913203601 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE language_codes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE language_codes (id INT NOT NULL, two_letter_code VARCHAR(2) NOT NULL, three_letter_code VARCHAR(3) NOT NULL, title_translation_key VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9AF5C51C281ED1D5 ON language_codes (two_letter_code)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9AF5C51CF4B592EE ON language_codes (three_letter_code)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9AF5C51C7AEB11FF ON language_codes (title_translation_key)');
        $this->addSql('COMMENT ON COLUMN language_codes.two_letter_code IS \'ISO 639 two-letter country code\'');
        $this->addSql('COMMENT ON COLUMN language_codes.three_letter_code IS \'Three-letter ISO 639-2 country code\'');
        $this->addSql('COMMENT ON COLUMN language_codes.title_translation_key IS \'The name of the language is the key to translation\'');
        $this->addSql('COMMENT ON COLUMN language_codes.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN language_codes.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE language_codes_id_seq CASCADE');
        $this->addSql('DROP TABLE language_codes');
    }
}
