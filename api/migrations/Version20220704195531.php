<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704195531 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE multimedia_media_library ADD title VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE multimedia_media_library ADD image TEXT DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN multimedia_media_library.title IS \'The name of the media that will be visible only inside the music library\'');
        $this->addSql('COMMENT ON COLUMN multimedia_media_library.image IS \'Media image that will only be visible inside the Music Library\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE multimedia_media_library DROP title');
        $this->addSql('ALTER TABLE multimedia_media_library DROP image');
    }
}
