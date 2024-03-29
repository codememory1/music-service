<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221211183819 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription_permissions ADD value JSON DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN subscription_permissions.value IS \'Subscription permission value\'');
        $this->addSql('COMMENT ON COLUMN user_settings.accept_multimedia_from_friends IS \'\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription_permissions DROP value');
    }
}
