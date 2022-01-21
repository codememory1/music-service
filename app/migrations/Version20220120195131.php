<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120195131 extends AbstractMigration
{

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE user_subscriptions (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, subscription_id INT NOT NULL, valid_to VARCHAR(255) NOT NULL COMMENT \'Subscription duration in the format 30d 10m, etc.\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_EAF92751A76ED395 (user_id), UNIQUE INDEX UNIQ_EAF927519A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_subscriptions ADD CONSTRAINT FK_EAF92751A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_subscriptions ADD CONSTRAINT FK_EAF927519A1887DC FOREIGN KEY (subscription_id) REFERENCES subscriptions (id)');

    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {

        $this->addSql('DROP TABLE user_subscriptions');

    }

}
