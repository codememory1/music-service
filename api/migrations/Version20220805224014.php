<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220805224014 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE running_multimedia_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE streams_running_multimedia_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE running_multimedia (id INT NOT NULL, user_session_id INT NOT NULL, multimedia_id INT NOT NULL, "current_time" DOUBLE PRECISION NOT NULL, is_playing BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6E9A7E34C6582A33 ON running_multimedia (user_session_id)');
        $this->addSql('CREATE INDEX IDX_6E9A7E3420531EB8 ON running_multimedia (multimedia_id)');
        $this->addSql('COMMENT ON COLUMN running_multimedia."current_time" IS \'Time at which multimedia plays\'');
        $this->addSql('COMMENT ON COLUMN running_multimedia.is_playing IS \'Is media currently running\'');
        $this->addSql('COMMENT ON COLUMN running_multimedia.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN running_multimedia.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE streams_running_multimedia (id INT NOT NULL, running_multimedia_id INT NOT NULL, from_user_session_id INT NOT NULL, to_user_session_id INT NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1C2B5B5BE445A630 ON streams_running_multimedia (running_multimedia_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1C2B5B5B8F5F4F2C ON streams_running_multimedia (from_user_session_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1C2B5B5B47846E52 ON streams_running_multimedia (to_user_session_id)');
        $this->addSql('COMMENT ON COLUMN streams_running_multimedia.status IS \'Streaming status from StreamMultimediaStatusEnum\'');
        $this->addSql('COMMENT ON COLUMN streams_running_multimedia.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN streams_running_multimedia.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE running_multimedia ADD CONSTRAINT FK_6E9A7E34C6582A33 FOREIGN KEY (user_session_id) REFERENCES user_sessions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE running_multimedia ADD CONSTRAINT FK_6E9A7E3420531EB8 FOREIGN KEY (multimedia_id) REFERENCES multimedia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE streams_running_multimedia ADD CONSTRAINT FK_1C2B5B5BE445A630 FOREIGN KEY (running_multimedia_id) REFERENCES running_multimedia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE streams_running_multimedia ADD CONSTRAINT FK_1C2B5B5B8F5F4F2C FOREIGN KEY (from_user_session_id) REFERENCES user_sessions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE streams_running_multimedia ADD CONSTRAINT FK_1C2B5B5B47846E52 FOREIGN KEY (to_user_session_id) REFERENCES user_sessions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE streams_running_multimedia DROP CONSTRAINT FK_1C2B5B5BE445A630');
        $this->addSql('DROP SEQUENCE running_multimedia_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE streams_running_multimedia_id_seq CASCADE');
        $this->addSql('DROP TABLE running_multimedia');
        $this->addSql('DROP TABLE streams_running_multimedia');
    }
}
