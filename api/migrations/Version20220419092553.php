<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419092553 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ADD type_auth_social_network VARCHAR(50) DEFAULT NULL COMMENT \'Type of social network in which the user is authorized\', ADD social_network_auth_id LONGTEXT DEFAULT NULL COMMENT \'Unique identifier of an authorized user in a social network\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E93B1C0175 ON users (social_network_auth_id)');
        $this->addSql('ALTER TABLE messenger_messages CHANGE queue_name queue_name VARCHAR(190) NOT NULL');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX IDX_75EA56E0FB7336F0 ON messenger_messages');
        $this->addSql('DROP INDEX IDX_75EA56E0E3BD61CE ON messenger_messages');
        $this->addSql('ALTER TABLE messenger_messages CHANGE queue_name queue_name VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_1483A5E93B1C0175 ON users');
        $this->addSql('ALTER TABLE users DROP type_auth_social_network, DROP social_network_auth_id');
    }
}
