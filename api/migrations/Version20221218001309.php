<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221218001309 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE multimedia_external_services ADD status VARCHAR(255) NOT NULL');
        $this->addSql('COMMENT ON COLUMN multimedia_external_services.status IS \'Status from MultimediaExternalServiceStatusEnum\'');
        $this->addSql('ALTER TABLE password_resets ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE password_resets ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE password_resets ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE platform_settings ALTER value TYPE TEXT');
        $this->addSql('ALTER TABLE platform_settings ALTER value DROP DEFAULT');
        $this->addSql('ALTER TABLE users ALTER password TYPE TEXT');
        $this->addSql('ALTER TABLE users ALTER password DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE password_resets ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE password_resets ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE password_resets ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE users ALTER password TYPE TEXT');
        $this->addSql('ALTER TABLE users ALTER password DROP DEFAULT');
        $this->addSql('ALTER TABLE platform_settings ALTER value TYPE TEXT');
        $this->addSql('ALTER TABLE platform_settings ALTER value DROP DEFAULT');
        $this->addSql('ALTER TABLE multimedia_external_services DROP status');
    }
}
