<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220709101235 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE multimedia_playlist_from_media_library_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE multimedia_playlist_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE multimedia_playlist_directory_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE playlist_directories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE multimedia_playlist (id INT NOT NULL, playlist_id INT NOT NULL, multimedia_media_library_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7B83E2D66BBD148 ON multimedia_playlist (playlist_id)');
        $this->addSql('CREATE INDEX IDX_7B83E2D67D1C0629 ON multimedia_playlist (multimedia_media_library_id)');
        $this->addSql('COMMENT ON COLUMN multimedia_playlist.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia_playlist.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE multimedia_playlist_directory (id INT NOT NULL, playlist_directory_id INT NOT NULL, multimedia_media_library_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7EF0B54C8760F640 ON multimedia_playlist_directory (playlist_directory_id)');
        $this->addSql('CREATE INDEX IDX_7EF0B54C7D1C0629 ON multimedia_playlist_directory (multimedia_media_library_id)');
        $this->addSql('COMMENT ON COLUMN multimedia_playlist_directory.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia_playlist_directory.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE playlist_directories (id INT NOT NULL, playlist_id INT NOT NULL, title VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A3D266A06BBD148 ON playlist_directories (playlist_id)');
        $this->addSql('COMMENT ON COLUMN playlist_directories.title IS \'Directory name\'');
        $this->addSql('COMMENT ON COLUMN playlist_directories.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN playlist_directories.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE multimedia_playlist ADD CONSTRAINT FK_7B83E2D66BBD148 FOREIGN KEY (playlist_id) REFERENCES playlists (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_playlist ADD CONSTRAINT FK_7B83E2D67D1C0629 FOREIGN KEY (multimedia_media_library_id) REFERENCES multimedia_media_library (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_playlist_directory ADD CONSTRAINT FK_7EF0B54C8760F640 FOREIGN KEY (playlist_directory_id) REFERENCES playlist_directories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_playlist_directory ADD CONSTRAINT FK_7EF0B54C7D1C0629 FOREIGN KEY (multimedia_media_library_id) REFERENCES multimedia_media_library (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_directories ADD CONSTRAINT FK_A3D266A06BBD148 FOREIGN KEY (playlist_id) REFERENCES playlists (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE multimedia_playlist_from_media_library');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE multimedia_playlist_directory DROP CONSTRAINT FK_7EF0B54C8760F640');
        $this->addSql('DROP SEQUENCE multimedia_playlist_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE multimedia_playlist_directory_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE playlist_directories_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE multimedia_playlist_from_media_library_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE multimedia_playlist_from_media_library (id INT NOT NULL, playlist_id INT NOT NULL, multimedia_media_library_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_509d11577d1c0629 ON multimedia_playlist_from_media_library (multimedia_media_library_id)');
        $this->addSql('CREATE INDEX idx_509d11576bbd148 ON multimedia_playlist_from_media_library (playlist_id)');
        $this->addSql('COMMENT ON COLUMN multimedia_playlist_from_media_library.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia_playlist_from_media_library.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE multimedia_playlist_from_media_library ADD CONSTRAINT fk_509d11576bbd148 FOREIGN KEY (playlist_id) REFERENCES playlists (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_playlist_from_media_library ADD CONSTRAINT fk_509d11577d1c0629 FOREIGN KEY (multimedia_media_library_id) REFERENCES multimedia_media_library (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE multimedia_playlist');
        $this->addSql('DROP TABLE multimedia_playlist_directory');
        $this->addSql('DROP TABLE playlist_directories');
    }
}
