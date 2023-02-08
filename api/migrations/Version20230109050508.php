<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109050508 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription_extenders DROP CONSTRAINT fk_f5b6694cdbd68400');
        $this->addSql('DROP INDEX idx_f5b6694cdbd68400');
        $this->addSql('ALTER TABLE subscription_extenders RENAME COLUMN extender_id TO basic_subscription_id');
        $this->addSql('ALTER TABLE subscription_extenders ADD CONSTRAINT FK_F5B6694C63DDB749 FOREIGN KEY (basic_subscription_id) REFERENCES subscriptions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F5B6694C63DDB749 ON subscription_extenders (basic_subscription_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription_extenders DROP CONSTRAINT FK_F5B6694C63DDB749');
        $this->addSql('DROP INDEX IDX_F5B6694C63DDB749');
        $this->addSql('ALTER TABLE subscription_extenders RENAME COLUMN basic_subscription_id TO extender_id');
        $this->addSql('ALTER TABLE subscription_extenders ADD CONSTRAINT fk_f5b6694cdbd68400 FOREIGN KEY (extender_id) REFERENCES subscriptions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f5b6694cdbd68400 ON subscription_extenders (extender_id)');
    }
}
