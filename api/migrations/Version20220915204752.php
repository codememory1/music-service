<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220915204752 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE multimedia_time_codes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE multimedia_time_codes (id INT NOT NULL, multimedia_id INT NOT NULL, preview TEXT DEFAULT NULL, from_time INT NOT NULL, to_time INT NOT NULL, title VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_732317E020531EB8 ON multimedia_time_codes (multimedia_id)');
        $this->addSql('COMMENT ON COLUMN multimedia_time_codes.preview IS \'Path to preview time code\'');
        $this->addSql('COMMENT ON COLUMN multimedia_time_codes.from_time IS \'Time code from time\'');
        $this->addSql('COMMENT ON COLUMN multimedia_time_codes.to_time IS \'Time code to time\'');
        $this->addSql('COMMENT ON COLUMN multimedia_time_codes.title IS \'The name of the time code is short about the moment what is happening here\'');
        $this->addSql('COMMENT ON COLUMN multimedia_time_codes.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia_time_codes.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE multimedia_time_codes ADD CONSTRAINT FK_732317E020531EB8 FOREIGN KEY (multimedia_id) REFERENCES multimedia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE multimedia_time_codes_id_seq CASCADE');
        $this->addSql('DROP TABLE multimedia_time_codes');
    }
}
