<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220521020036 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE role_permission_keys_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE role_permissions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE roles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE role_permission_keys (id INT NOT NULL, key VARCHAR(255) NOT NULL, title_translation_key VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2A93C3E68A90ABA9 ON role_permission_keys (key)');
        $this->addSql('COMMENT ON COLUMN role_permission_keys.key IS \'Unique key, to verify the right\'');
        $this->addSql('COMMENT ON COLUMN role_permission_keys.title_translation_key IS \'The name of this right as a translation key\'');
        $this->addSql('COMMENT ON COLUMN role_permission_keys.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN role_permission_keys.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE role_permissions (id INT NOT NULL, role_id INT NOT NULL, role_permission_key_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1FBA94E6D60322AC ON role_permissions (role_id)');
        $this->addSql('CREATE INDEX IDX_1FBA94E684273527 ON role_permissions (role_permission_key_id)');
        $this->addSql('COMMENT ON COLUMN role_permissions.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN role_permissions.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE roles (id INT NOT NULL, key VARCHAR(255) NOT NULL, title_translation_key VARCHAR(255) NOT NULL, short_description_translation_key VARCHAR(300) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B63E2EC78A90ABA9 ON roles (key)');
        $this->addSql('COMMENT ON COLUMN roles.key IS \'Unique processing key\'');
        $this->addSql('COMMENT ON COLUMN roles.title_translation_key IS \'The name of this role as a translation key\'');
        $this->addSql('COMMENT ON COLUMN roles.short_description_translation_key IS \'Brief description of this role in the form of a translation key\'');
        $this->addSql('COMMENT ON COLUMN roles.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN roles.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE role_permissions ADD CONSTRAINT FK_1FBA94E6D60322AC FOREIGN KEY (role_id) REFERENCES roles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE role_permissions ADD CONSTRAINT FK_1FBA94E684273527 FOREIGN KEY (role_permission_key_id) REFERENCES role_permission_keys (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE role_permissions DROP CONSTRAINT FK_1FBA94E684273527');
        $this->addSql('ALTER TABLE role_permissions DROP CONSTRAINT FK_1FBA94E6D60322AC');
        $this->addSql('DROP SEQUENCE role_permission_keys_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE role_permissions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE roles_id_seq CASCADE');
        $this->addSql('DROP TABLE role_permission_keys');
        $this->addSql('DROP TABLE role_permissions');
        $this->addSql('DROP TABLE roles');
    }
}
