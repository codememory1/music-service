<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608214823 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notifications ADD to_user VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE notifications ADD status VARCHAR(255) NOT NULL');
        $this->addSql('COMMENT ON COLUMN notifications.to_user IS \'User email or all if you want to send all registered users\'');
        $this->addSql('COMMENT ON COLUMN notifications.status IS \'Notification status from NotificationStatusEnum\'');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notifications DROP to_user');
        $this->addSql('ALTER TABLE notifications DROP status');
    }
}
