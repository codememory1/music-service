<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714203524 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE user_profile_designs_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_profile_designs (id INT NOT NULL, user_profile_id INT NOT NULL, cover_image TEXT NOT NULL, design_components TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FC7802EE6B9DD454 ON user_profile_designs (user_profile_id)');
        $this->addSql('COMMENT ON COLUMN user_profile_designs.cover_image IS \'Main image\'');
        $this->addSql('COMMENT ON COLUMN user_profile_designs.design_components IS \'Design components according to the user_profile_design.json schema(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN user_profile_designs.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_profile_designs.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_profile_designs ADD CONSTRAINT FK_FC7802EE6B9DD454 FOREIGN KEY (user_profile_id) REFERENCES user_profiles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE user_profile_designs_id_seq CASCADE');
        $this->addSql('DROP TABLE user_profile_designs');
    }
}
