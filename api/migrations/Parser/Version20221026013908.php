<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221026013908 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE albums (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, artist_id INTEGER NOT NULL, name VARCHAR(255) DEFAULT NULL, image_link CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_F4E2474FB7970CF8 ON albums (artist_id)');
        $this->addSql('CREATE TABLE artist_photos (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, artist_id INTEGER NOT NULL, link CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_FA74ECA7B7970CF8 ON artist_photos (artist_id)');
        $this->addSql('CREATE TABLE artists (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, biography CLOB DEFAULT NULL, date_birth DATE DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE TABLE multimedia (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, artist_id INTEGER NOT NULL, album_id INTEGER DEFAULT NULL, type VARCHAR(10) NOT NULL, name VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, text CLOB DEFAULT NULL, is_obscene_words BOOLEAN NOT NULL, image_link CLOB DEFAULT NULL, link_to_media CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_61312863B7970CF8 ON multimedia (artist_id)');
        $this->addSql('CREATE INDEX IDX_613128631137ABCF ON multimedia (album_id)');
        $this->addSql('CREATE TABLE multimedia_tags (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, multimedia_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_D0C2BB3020531EB8 ON multimedia_tags (multimedia_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE albums');
        $this->addSql('DROP TABLE artist_photos');
        $this->addSql('DROP TABLE artists');
        $this->addSql('DROP TABLE multimedia');
        $this->addSql('DROP TABLE multimedia_tags');
    }
}
