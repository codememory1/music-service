<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221126013218 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE monetization_branch_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE monetization_branch (id INT NOT NULL, key VARCHAR(255) NOT NULL, value TEXT NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN monetization_branch.key IS \'The name of the key for which there is logic\'');
        $this->addSql('COMMENT ON COLUMN monetization_branch.value IS \'Key value(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN monetization_branch.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE monetization_branch_id_seq CASCADE');
        $this->addSql('DROP TABLE monetization_branch');
    }
}
