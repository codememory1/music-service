<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221223000040 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE entity_errors_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE entity_errors (id INT NOT NULL, platform_code INT NOT NULL, message VARCHAR(255) NOT NULL, message_parameters JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN entity_errors.platform_code IS \'Error code from PlatformCodeEnum\'');
        $this->addSql('COMMENT ON COLUMN entity_errors.message IS \'Error message, must be in the form of a translation key\'');
        $this->addSql('COMMENT ON COLUMN entity_errors.message_parameters IS \'Parameters for the message\'');
        $this->addSql('COMMENT ON COLUMN entity_errors.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE entity_errors_id_seq CASCADE');
        $this->addSql('DROP TABLE entity_errors');
    }
}
