<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220603234919 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE albums_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE albums (id INT NOT NULL, user_id INT NOT NULL, type_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image TEXT NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F4E2474FA76ED395 ON albums (user_id)');
        $this->addSql('CREATE INDEX IDX_F4E2474FC54C8C93 ON albums (type_id)');
        $this->addSql('COMMENT ON COLUMN albums.title IS \'Album name\'');
        $this->addSql('COMMENT ON COLUMN albums.description IS \'Album description\'');
        $this->addSql('COMMENT ON COLUMN albums.image IS \'Album image as path to s3\'');
        $this->addSql('COMMENT ON COLUMN albums.status IS \'Album status from AlbumStatusEnum\'');
        $this->addSql('COMMENT ON COLUMN albums.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN albums.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE albums ADD CONSTRAINT FK_F4E2474FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE albums ADD CONSTRAINT FK_F4E2474FC54C8C93 FOREIGN KEY (type_id) REFERENCES album_types (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE albums_id_seq CASCADE');
        $this->addSql('DROP TABLE albums');
    }
}
