<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804190630 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE media_library_statistics_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE media_library_statistics (id INT NOT NULL, media_library_id INT NOT NULL, number_of_tracks INT NOT NULL, number_of_clips INT NOT NULL, number_of_playlists INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2CFE6AA7F4008F43 ON media_library_statistics (media_library_id)');
        $this->addSql('COMMENT ON COLUMN media_library_statistics.number_of_tracks IS \'Total number of tracks in the library\'');
        $this->addSql('COMMENT ON COLUMN media_library_statistics.number_of_clips IS \'Total number of clips in the library\'');
        $this->addSql('COMMENT ON COLUMN media_library_statistics.number_of_playlists IS \'Number of playlists in the library\'');
        $this->addSql('COMMENT ON COLUMN media_library_statistics.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN media_library_statistics.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE media_library_statistics ADD CONSTRAINT FK_2CFE6AA7F4008F43 FOREIGN KEY (media_library_id) REFERENCES media_libraries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE media_library_statistics_id_seq CASCADE');
        $this->addSql('DROP TABLE media_library_statistics');
    }
}
