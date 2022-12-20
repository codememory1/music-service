<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220927114306 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('COMMENT ON COLUMN notifications.departure_date IS \'The date on which the notification should be sent(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP INDEX uniq_1c2b5b5b8f5f4f2c');
        $this->addSql('DROP INDEX uniq_1c2b5b5b47846e52');
        $this->addSql('DROP INDEX uniq_1c2b5b5be445a630');
        $this->addSql('CREATE INDEX IDX_1C2B5B5BE445A630 ON streams_running_multimedia (running_multimedia_id)');
        $this->addSql('CREATE INDEX IDX_1C2B5B5B8F5F4F2C ON streams_running_multimedia (from_user_session_id)');
        $this->addSql('CREATE INDEX IDX_1C2B5B5B47846E52 ON streams_running_multimedia (to_user_session_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_1C2B5B5BE445A630');
        $this->addSql('DROP INDEX IDX_1C2B5B5B8F5F4F2C');
        $this->addSql('DROP INDEX IDX_1C2B5B5B47846E52');
        $this->addSql('CREATE UNIQUE INDEX uniq_1c2b5b5b8f5f4f2c ON streams_running_multimedia (from_user_session_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_1c2b5b5b47846e52 ON streams_running_multimedia (to_user_session_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_1c2b5b5be445a630 ON streams_running_multimedia (running_multimedia_id)');
        $this->addSql('COMMENT ON COLUMN notifications.departure_date IS \'Notification status from NotificationStatusEnum(DC2Type:datetime_immutable)\'');
    }
}
