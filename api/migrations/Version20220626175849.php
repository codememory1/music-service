<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220626175849 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE multimedia_ratings_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE multimedia_ratings (id INT NOT NULL, multimedia_id INT NOT NULL, user_id INT NOT NULL, type VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_73BCBCE220531EB8 ON multimedia_ratings (multimedia_id)');
        $this->addSql('CREATE INDEX IDX_73BCBCE2A76ED395 ON multimedia_ratings (user_id)');
        $this->addSql('COMMENT ON COLUMN multimedia_ratings.type IS \'Assessment type from MultimediaRatingTypeEnum\'');
        $this->addSql('COMMENT ON COLUMN multimedia_ratings.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia_ratings.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE multimedia_ratings ADD CONSTRAINT FK_73BCBCE220531EB8 FOREIGN KEY (multimedia_id) REFERENCES multimedia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_ratings ADD CONSTRAINT FK_73BCBCE2A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE multimedia_ratings_id_seq CASCADE');
        $this->addSql('DROP TABLE multimedia_ratings');
    }
}
