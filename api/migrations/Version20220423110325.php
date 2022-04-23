<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220423110325 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_1483A5E9F85E0677 ON users');
        $this->addSql('ALTER TABLE users DROP username');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ADD username VARCHAR(250) NOT NULL COMMENT \'The default username is the truncated mail then the symbol @\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
    }
}
