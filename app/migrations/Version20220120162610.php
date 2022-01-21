<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120162610 extends AbstractMigration
{

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE subscription_right_names (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) NOT NULL COMMENT \'The unique key of the rule by which access will be checked\', title_translation_key VARCHAR(255) NOT NULL COMMENT \'Rule name translation key\', UNIQUE INDEX UNIQ_37C3A2D74E645A7E (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_rights (id INT AUTO_INCREMENT NOT NULL, subscription_right_name_id INT NOT NULL, subscription_id INT NOT NULL, INDEX IDX_C896C98478CF7E0B (subscription_right_name_id), INDEX IDX_C896C9849A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscriptions (id INT AUTO_INCREMENT NOT NULL, name_translation_key VARCHAR(255) NOT NULL COMMENT \'Subscription name translation key\', description_translation_key VARCHAR(255) NOT NULL COMMENT \'Subscription description translation key\', price NUMERIC(10, 2) NOT NULL COMMENT \'Subscription price\', old_price NUMERIC(10, 2) DEFAULT NULL COMMENT \'Old subscription price\', status INT NOT NULL COMMENT \'Subscription status, default StatusEnum::ACTIVE\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subscription_rights ADD CONSTRAINT FK_C896C98478CF7E0B FOREIGN KEY (subscription_right_name_id) REFERENCES subscription_right_names (id)');
        $this->addSql('ALTER TABLE subscription_rights ADD CONSTRAINT FK_C896C9849A1887DC FOREIGN KEY (subscription_id) REFERENCES subscriptions (id)');

    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {

        $this->addSql('ALTER TABLE subscription_rights DROP FOREIGN KEY FK_C896C98478CF7E0B');
        $this->addSql('ALTER TABLE subscription_rights DROP FOREIGN KEY FK_C896C9849A1887DC');
        $this->addSql('DROP TABLE subscription_right_names');
        $this->addSql('DROP TABLE subscription_rights');
        $this->addSql('DROP TABLE subscriptions');

    }

}
