<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220626174511 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE multimedia_auditions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE multimedia_shares_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE multimedia_auditions (id INT NOT NULL, multimedia_id INT NOT NULL, user_id INT NOT NULL, is_full BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8E5168A20531EB8 ON multimedia_auditions (multimedia_id)');
        $this->addSql('CREATE INDEX IDX_8E5168AA76ED395 ON multimedia_auditions (user_id)');
        $this->addSql('COMMENT ON COLUMN multimedia_auditions.is_full IS \'Is it full listening - no rewinds\'');
        $this->addSql('COMMENT ON COLUMN multimedia_auditions.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia_auditions.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE multimedia_shares (id INT NOT NULL, multimedia_id INT NOT NULL, from_user_id INT NOT NULL, to_user_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2716468C20531EB8 ON multimedia_shares (multimedia_id)');
        $this->addSql('CREATE INDEX IDX_2716468C2130303A ON multimedia_shares (from_user_id)');
        $this->addSql('CREATE INDEX IDX_2716468C29F6EE60 ON multimedia_shares (to_user_id)');
        $this->addSql('COMMENT ON COLUMN multimedia_shares.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia_shares.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE multimedia_auditions ADD CONSTRAINT FK_8E5168A20531EB8 FOREIGN KEY (multimedia_id) REFERENCES multimedia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_auditions ADD CONSTRAINT FK_8E5168AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_shares ADD CONSTRAINT FK_2716468C20531EB8 FOREIGN KEY (multimedia_id) REFERENCES multimedia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_shares ADD CONSTRAINT FK_2716468C2130303A FOREIGN KEY (from_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_shares ADD CONSTRAINT FK_2716468C29F6EE60 FOREIGN KEY (to_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE multimedia_auditions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE multimedia_shares_id_seq CASCADE');
        $this->addSql('DROP TABLE multimedia_auditions');
        $this->addSql('DROP TABLE multimedia_shares');
    }
}
