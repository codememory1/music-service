<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221220005524 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE monetization_branch ALTER value TYPE JSON USING value::json');
        $this->addSql('ALTER TABLE monetization_branch ALTER value DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN monetization_branch.value IS \'Key value\'');
        $this->addSql('ALTER TABLE subscription_permission_branch ALTER value TYPE JSON USING value::json');
        $this->addSql('ALTER TABLE subscription_permission_branch ALTER value DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN subscription_permission_branch.value IS \'Key value\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription_permission_branch ALTER value TYPE TEXT');
        $this->addSql('ALTER TABLE subscription_permission_branch ALTER value DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN subscription_permission_branch.value IS \'Key value(DC2Type:array)\'');
        $this->addSql('ALTER TABLE monetization_branch ALTER value TYPE TEXT');
        $this->addSql('ALTER TABLE monetization_branch ALTER value DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN monetization_branch.value IS \'Key value(DC2Type:array)\'');
    }
}
