<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220611011953 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD id_in_auth_service VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD auth_service_type VARCHAR(25) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ALTER password DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN users.id_in_auth_service IS \'Unique id of your profile in the authorization service\'');
        $this->addSql('COMMENT ON COLUMN users.auth_service_type IS \'The type of service in which authorization occurred\'');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP id_in_auth_service');
        $this->addSql('ALTER TABLE users DROP auth_service_type');
        $this->addSql('ALTER TABLE users ALTER password SET NOT NULL');
    }
}
