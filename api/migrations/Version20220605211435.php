<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220605211435 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_6dc85ec9a76ed395');
        $this->addSql('CREATE INDEX IDX_6DC85EC9A76ED395 ON account_activation_codes (user_id)');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_6DC85EC9A76ED395');
        $this->addSql('CREATE UNIQUE INDEX uniq_6dc85ec9a76ed395 ON account_activation_codes (user_id)');
    }
}
