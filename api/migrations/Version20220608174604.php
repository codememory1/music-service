<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608174604 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE user_notifications_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_notifications (id INT NOT NULL, to_user_id INT NOT NULL, notification_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8E8E1D8329F6EE60 ON user_notifications (to_user_id)');
        $this->addSql('CREATE INDEX IDX_8E8E1D83EF1A9D84 ON user_notifications (notification_id)');
        $this->addSql('COMMENT ON COLUMN user_notifications.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_notifications.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_notifications ADD CONSTRAINT FK_8E8E1D8329F6EE60 FOREIGN KEY (to_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_notifications ADD CONSTRAINT FK_8E8E1D83EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notifications (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP INDEX idx_6000b0d329f6ee60');
        $this->addSql('ALTER TABLE notifications DROP to_user_id');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_notifications_id_seq CASCADE');
        $this->addSql('DROP TABLE user_notifications');
        $this->addSql('ALTER TABLE notifications ADD to_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT fk_6000b0d329f6ee60 FOREIGN KEY (to_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6000b0d329f6ee60 ON notifications (to_user_id)');
    }
}
