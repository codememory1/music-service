<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220731000344 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE albums ADD uuid VARCHAR(100) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F4E2474FD17F50A6 ON albums (uuid)');
        $this->addSql('ALTER TABLE multimedia ADD uuid VARCHAR(100) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_61312863D17F50A6 ON multimedia (uuid)');
        $this->addSql('ALTER TABLE multimedia_media_library ADD uuid VARCHAR(100) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_68105F22D17F50A6 ON multimedia_media_library (uuid)');
        $this->addSql('ALTER TABLE playlists ADD uuid VARCHAR(100) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E06116FD17F50A6 ON playlists (uuid)');
        $this->addSql('ALTER TABLE user_profile_designs ADD uuid VARCHAR(100) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FC7802EED17F50A6 ON user_profile_designs (uuid)');
        $this->addSql('ALTER TABLE user_profiles ADD uuid VARCHAR(100) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6BBD6130D17F50A6 ON user_profiles (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_68105F22D17F50A6');
        $this->addSql('ALTER TABLE multimedia_media_library DROP uuid');
        $this->addSql('DROP INDEX UNIQ_5E06116FD17F50A6');
        $this->addSql('ALTER TABLE playlists DROP uuid');
        $this->addSql('DROP INDEX UNIQ_FC7802EED17F50A6');
        $this->addSql('ALTER TABLE user_profile_designs DROP uuid');
        $this->addSql('DROP INDEX UNIQ_61312863D17F50A6');
        $this->addSql('ALTER TABLE multimedia DROP uuid');
        $this->addSql('DROP INDEX UNIQ_F4E2474FD17F50A6');
        $this->addSql('ALTER TABLE albums DROP uuid');
        $this->addSql('DROP INDEX UNIQ_6BBD6130D17F50A6');
        $this->addSql('ALTER TABLE user_profiles DROP uuid');
    }
}
