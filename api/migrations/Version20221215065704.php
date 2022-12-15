<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221215065704 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_settings ADD multimedia_stream JSON NOT NULL');
        $this->addSql('COMMENT ON COLUMN user_settings.multimedia_stream IS \'Control over media flow\'');
        $this->addSql('COMMENT ON COLUMN user_settings.accept_multimedia_from_friends IS \'Permission to automatically accept media sent by a friend\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_settings DROP multimedia_stream');
        $this->addSql('COMMENT ON COLUMN user_settings.accept_multimedia_from_friends IS NULL');
    }
}
