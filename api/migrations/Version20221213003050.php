<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221213003050 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE multimedia_external_services_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE multimedia_external_services (id INT NOT NULL, user_id INT NOT NULL, service_name VARCHAR(25) NOT NULL, parameters JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_31D0C755A76ED395 ON multimedia_external_services (user_id)');
        $this->addSql('COMMENT ON COLUMN multimedia_external_services.service_name IS \'Service name from MultimediaExternalServiceEnum\'');
        $this->addSql('COMMENT ON COLUMN multimedia_external_services.parameters IS \'Parameters that will be needed to get the clip, for example, some get parameters, etc.\'');
        $this->addSql('COMMENT ON COLUMN multimedia_external_services.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia_external_services.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE multimedia_external_services ADD CONSTRAINT FK_31D0C755A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE multimedia_external_services_id_seq CASCADE');
        $this->addSql('DROP TABLE multimedia_external_services');
    }
}
