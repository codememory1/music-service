<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220711234638 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_sessions ADD continent VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_sessions ADD country_code VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_sessions ADD region VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_sessions ADD region_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_sessions ADD timezone VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_sessions ADD currency VARCHAR(10) DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN user_sessions.continent IS \'Continent\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.country_code IS \'Code of the country\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.region IS \'Region code\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.region_name IS \'Region name\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.timezone IS \'Time zone\'');
        $this->addSql('COMMENT ON COLUMN user_sessions.currency IS \'Country currency\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_sessions DROP continent');
        $this->addSql('ALTER TABLE user_sessions DROP country_code');
        $this->addSql('ALTER TABLE user_sessions DROP region');
        $this->addSql('ALTER TABLE user_sessions DROP region_name');
        $this->addSql('ALTER TABLE user_sessions DROP timezone');
        $this->addSql('ALTER TABLE user_sessions DROP currency');
    }
}
