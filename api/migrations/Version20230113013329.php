<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230113013329 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE subscription_ui_permissions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE subscription_ui_permissions (id INT NOT NULL, subscription_id INT NOT NULL, permission_id INT DEFAULT NULL, title_translation_key VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1495E2639A1887DC ON subscription_ui_permissions (subscription_id)');
        $this->addSql('CREATE INDEX IDX_1495E263FED90CCA ON subscription_ui_permissions (permission_id)');
        $this->addSql('COMMENT ON COLUMN subscription_ui_permissions.title_translation_key IS \'Permission name as a translation key\'');
        $this->addSql('COMMENT ON COLUMN subscription_ui_permissions.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN subscription_ui_permissions.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE subscription_ui_permissions ADD CONSTRAINT FK_1495E2639A1887DC FOREIGN KEY (subscription_id) REFERENCES subscriptions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription_ui_permissions ADD CONSTRAINT FK_1495E263FED90CCA FOREIGN KEY (permission_id) REFERENCES subscription_permissions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE subscription_ui_permissions_id_seq CASCADE');
        $this->addSql('DROP TABLE subscription_ui_permissions');
    }
}
