<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220908222047 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE multimedia_listening_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE multimedia_listening_history (id INT NOT NULL, multimedia_id INT NOT NULL, user_id INT DEFAULT NULL, "current_time" DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BAFEBDE820531EB8 ON multimedia_listening_history (multimedia_id)');
        $this->addSql('CREATE INDEX IDX_BAFEBDE8A76ED395 ON multimedia_listening_history (user_id)');
        $this->addSql('COMMENT ON COLUMN multimedia_listening_history."current_time" IS \'The time at which listening stopped\'');
        $this->addSql('COMMENT ON COLUMN multimedia_listening_history.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia_listening_history.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE multimedia_listening_history ADD CONSTRAINT FK_BAFEBDE820531EB8 FOREIGN KEY (multimedia_id) REFERENCES multimedia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_listening_history ADD CONSTRAINT FK_BAFEBDE8A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE multimedia_listening_history_id_seq CASCADE');
        $this->addSql('DROP TABLE multimedia_listening_history');
    }
}
