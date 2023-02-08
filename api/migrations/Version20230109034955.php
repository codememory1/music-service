<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109034955 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE subscription_extenders_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE subscription_extenders (id INT NOT NULL, subscription_id INT NOT NULL, extender_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F5B6694C9A1887DC ON subscription_extenders (subscription_id)');
        $this->addSql('CREATE INDEX IDX_F5B6694CDBD68400 ON subscription_extenders (extender_id)');
        $this->addSql('COMMENT ON COLUMN subscription_extenders.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE subscription_extenders ADD CONSTRAINT FK_F5B6694C9A1887DC FOREIGN KEY (subscription_id) REFERENCES subscriptions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription_extenders ADD CONSTRAINT FK_F5B6694CDBD68400 FOREIGN KEY (extender_id) REFERENCES subscriptions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE albums ALTER image SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE subscription_extenders_id_seq CASCADE');
        $this->addSql('DROP TABLE subscription_extenders');
        $this->addSql('ALTER TABLE albums ALTER image DROP NOT NULL');
    }
}
