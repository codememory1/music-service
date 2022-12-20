<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220703190531 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE multimedia_media_library_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE multimedia_media_library (id INT NOT NULL, media_library_id INT NOT NULL, multimedia_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_68105F22F4008F43 ON multimedia_media_library (media_library_id)');
        $this->addSql('CREATE INDEX IDX_68105F2220531EB8 ON multimedia_media_library (multimedia_id)');
        $this->addSql('COMMENT ON COLUMN multimedia_media_library.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia_media_library.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE multimedia_media_library ADD CONSTRAINT FK_68105F22F4008F43 FOREIGN KEY (media_library_id) REFERENCES media_libraries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_media_library ADD CONSTRAINT FK_68105F2220531EB8 FOREIGN KEY (multimedia_id) REFERENCES multimedia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE multimedia_media_library_id_seq CASCADE');
        $this->addSql('DROP TABLE multimedia_media_library');
    }
}
