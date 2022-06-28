<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628000251 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE artist_subscribers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE artist_subscribers (id INT NOT NULL, artist_id INT NOT NULL, subscriber_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6F7A0EBB7970CF8 ON artist_subscribers (artist_id)');
        $this->addSql('CREATE INDEX IDX_6F7A0EB7808B1AD ON artist_subscribers (subscriber_id)');
        $this->addSql('COMMENT ON COLUMN artist_subscribers.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN artist_subscribers.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE artist_subscribers ADD CONSTRAINT FK_6F7A0EBB7970CF8 FOREIGN KEY (artist_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE artist_subscribers ADD CONSTRAINT FK_6F7A0EB7808B1AD FOREIGN KEY (subscriber_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE artist_subscribers_id_seq CASCADE');
        $this->addSql('DROP TABLE artist_subscribers');
    }
}
