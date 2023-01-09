<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109042215 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_4778a018a90aba9');
        $this->addSql('ALTER TABLE subscriptions DROP key');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscriptions ADD key VARCHAR(255) NOT NULL');
        $this->addSql('COMMENT ON COLUMN subscriptions.key IS \'Unique subscription key for identification\'');
        $this->addSql('CREATE UNIQUE INDEX uniq_4778a018a90aba9 ON subscriptions (key)');
    }
}
