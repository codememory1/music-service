<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220617224026 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE multimedia_metadata_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE multimedia_metadata (id INT NOT NULL, multimedia_id INT NOT NULL, duration DOUBLE PRECISION NOT NULL, bitrate INT DEFAULT NULL, framerate INT DEFAULT NULL, is_lossless BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E315C7EF20531EB8 ON multimedia_metadata (multimedia_id)');
        $this->addSql('COMMENT ON COLUMN multimedia_metadata.duration IS \'Media duration\'');
        $this->addSql('COMMENT ON COLUMN multimedia_metadata.bitrate IS \'Media bitrate\'');
        $this->addSql('COMMENT ON COLUMN multimedia_metadata.framerate IS \'Video frames per second\'');
        $this->addSql('COMMENT ON COLUMN multimedia_metadata.is_lossless IS \'Is there lossless compression?\'');
        $this->addSql('COMMENT ON COLUMN multimedia_metadata.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia_metadata.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE multimedia_metadata ADD CONSTRAINT FK_E315C7EF20531EB8 FOREIGN KEY (multimedia_id) REFERENCES multimedia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('COMMENT ON COLUMN multimedia.producer IS \'Multimedia producer\'');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE multimedia_metadata_id_seq CASCADE');
        $this->addSql('DROP TABLE multimedia_metadata');
        $this->addSql('COMMENT ON COLUMN multimedia.producer IS \'multimedia producer\'');
    }
}
