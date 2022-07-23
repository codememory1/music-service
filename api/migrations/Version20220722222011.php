<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220722222011 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE media_library_events_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE media_library_events (id INT NOT NULL, media_library_id INT NOT NULL, key VARCHAR(255) NOT NULL, payload TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_59503B81F4008F43 ON media_library_events (media_library_id)');
        $this->addSql('COMMENT ON COLUMN media_library_events.key IS \'Event key from MediaLibraryEventEnum\'');
        $this->addSql('COMMENT ON COLUMN media_library_events.payload IS \'Event Data(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN media_library_events.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN media_library_events.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE media_library_events ADD CONSTRAINT FK_59503B81F4008F43 FOREIGN KEY (media_library_id) REFERENCES media_libraries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE media_library_events_id_seq CASCADE');
        $this->addSql('DROP TABLE media_library_events');
        $this->addSql('COMMENT ON COLUMN user_settings.accept_multimedia_from_friends IS NULL');
    }
}
