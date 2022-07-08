<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705233051 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE multimedia_playlist_from_media_library_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE playlists_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE multimedia_playlist_from_media_library (id INT NOT NULL, playlist_id INT NOT NULL, multimedia_media_library_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_509D11576BBD148 ON multimedia_playlist_from_media_library (playlist_id)');
        $this->addSql('CREATE INDEX IDX_509D11577D1C0629 ON multimedia_playlist_from_media_library (multimedia_media_library_id)');
        $this->addSql('COMMENT ON COLUMN multimedia_playlist_from_media_library.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia_playlist_from_media_library.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE playlists (id INT NOT NULL, media_library_id INT NOT NULL, title VARCHAR(50) NOT NULL, image TEXT NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5E06116FF4008F43 ON playlists (media_library_id)');
        $this->addSql('COMMENT ON COLUMN playlists.title IS \'Playlist name\'');
        $this->addSql('COMMENT ON COLUMN playlists.image IS \'Playlist image path\'');
        $this->addSql('COMMENT ON COLUMN playlists.status IS \'Playlist status from PlaylistStatusEnum\'');
        $this->addSql('COMMENT ON COLUMN playlists.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN playlists.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE multimedia_playlist_from_media_library ADD CONSTRAINT FK_509D11576BBD148 FOREIGN KEY (playlist_id) REFERENCES playlists (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_playlist_from_media_library ADD CONSTRAINT FK_509D11577D1C0629 FOREIGN KEY (multimedia_media_library_id) REFERENCES multimedia_media_library (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlists ADD CONSTRAINT FK_5E06116FF4008F43 FOREIGN KEY (media_library_id) REFERENCES media_libraries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE multimedia_playlist_from_media_library DROP CONSTRAINT FK_509D11576BBD148');
        $this->addSql('DROP SEQUENCE multimedia_playlist_from_media_library_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE playlists_id_seq CASCADE');
        $this->addSql('DROP TABLE multimedia_playlist_from_media_library');
        $this->addSql('DROP TABLE playlists');
    }
}
