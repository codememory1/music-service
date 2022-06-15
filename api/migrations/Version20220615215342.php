<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220615215342 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE multimedia_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE multimedia_performers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE multimedia (id INT NOT NULL, user_id INT NOT NULL, album_id INT NOT NULL, category_id INT NOT NULL, type VARCHAR(255) NOT NULL, title VARCHAR(50) NOT NULL, description VARCHAR(500) DEFAULT NULL, multimedia VARCHAR(255) NOT NULL, text TEXT DEFAULT NULL, subtitles TEXT DEFAULT NULL, is_obscene_words BOOLEAN NOT NULL, image TEXT NOT NULL, producer VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_61312863A76ED395 ON multimedia (user_id)');
        $this->addSql('CREATE INDEX IDX_613128631137ABCF ON multimedia (album_id)');
        $this->addSql('CREATE INDEX IDX_6131286312469DE2 ON multimedia (category_id)');
        $this->addSql('COMMENT ON COLUMN multimedia.type IS \'Media type from MultimediaTypeEnum\'');
        $this->addSql('COMMENT ON COLUMN multimedia.title IS \'Media name\'');
        $this->addSql('COMMENT ON COLUMN multimedia.description IS \'Description of media\'');
        $this->addSql('COMMENT ON COLUMN multimedia.multimedia IS \'Path to file\'');
        $this->addSql('COMMENT ON COLUMN multimedia.text IS \'Full text of multimedia\'');
        $this->addSql('COMMENT ON COLUMN multimedia.subtitles IS \'Path to subtitle file\'');
        $this->addSql('COMMENT ON COLUMN multimedia.is_obscene_words IS \'Are there obscene words in the text\'');
        $this->addSql('COMMENT ON COLUMN multimedia.image IS \'Path to image file (preview)\'');
        $this->addSql('COMMENT ON COLUMN multimedia.producer IS \'multimedia producer\'');
        $this->addSql('COMMENT ON COLUMN multimedia.status IS \'Media status from MultimediaStatusEnum\'');
        $this->addSql('COMMENT ON COLUMN multimedia.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE multimedia_performers (id INT NOT NULL, user_id INT NOT NULL, multimedia_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FF3DE221A76ED395 ON multimedia_performers (user_id)');
        $this->addSql('CREATE INDEX IDX_FF3DE22120531EB8 ON multimedia_performers (multimedia_id)');
        $this->addSql('COMMENT ON COLUMN multimedia_performers.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN multimedia_performers.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE multimedia ADD CONSTRAINT FK_61312863A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia ADD CONSTRAINT FK_613128631137ABCF FOREIGN KEY (album_id) REFERENCES albums (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia ADD CONSTRAINT FK_6131286312469DE2 FOREIGN KEY (category_id) REFERENCES multimedia_categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_performers ADD CONSTRAINT FK_FF3DE221A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE multimedia_performers ADD CONSTRAINT FK_FF3DE22120531EB8 FOREIGN KEY (multimedia_id) REFERENCES multimedia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE multimedia_performers DROP CONSTRAINT FK_FF3DE22120531EB8');
        $this->addSql('DROP SEQUENCE multimedia_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE multimedia_performers_id_seq CASCADE');
        $this->addSql('DROP TABLE multimedia');
        $this->addSql('DROP TABLE multimedia_performers');
    }
}
