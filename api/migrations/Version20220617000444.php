<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220617000444 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE multimedia ALTER text TYPE TEXT');
        $this->addSql('ALTER TABLE multimedia ALTER text DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN multimedia.text IS \'Full text of multimedia(DC2Type:array)\'');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE multimedia ALTER text TYPE TEXT');
        $this->addSql('ALTER TABLE multimedia ALTER text DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN multimedia.text IS \'Full text of multimedia\'');
    }
}
