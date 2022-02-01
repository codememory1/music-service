<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120030856 extends AbstractMigration
{

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE languages (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(3) NOT NULL COMMENT \'Country code consisting of two to three characters\', title_translation_key VARCHAR(255) NOT NULL COMMENT \'Language name translation key\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_A0D1537977153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translation_keys (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COMMENT \'A unique key by which it will be possible to receive a transfer\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_99ACE7775E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translations (id INT AUTO_INCREMENT NOT NULL, lang_id INT NOT NULL, translation_key_id INT NOT NULL, translation LONGTEXT NOT NULL COMMENT \'Translation of the key into the specified language\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C6B7DA87B213FA4 (lang_id), INDEX IDX_C6B7DA87D07ED992 (translation_key_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE translations ADD CONSTRAINT FK_C6B7DA87B213FA4 FOREIGN KEY (lang_id) REFERENCES languages (id)');
        $this->addSql('ALTER TABLE translations ADD CONSTRAINT FK_C6B7DA87D07ED992 FOREIGN KEY (translation_key_id) REFERENCES translation_keys (id)');
        $this->addSql('ALTER TABLE role_right_names RENAME INDEX uniq_388e8ac98e85a347 TO UNIQ_388E8AC94E645A7E');
        $this->addSql('ALTER TABLE roles RENAME INDEX uniq_b63e2ec73ef22fdb TO UNIQ_B63E2EC74E645A7E');

    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {

        $this->addSql('ALTER TABLE translations DROP FOREIGN KEY FK_C6B7DA87B213FA4');
        $this->addSql('ALTER TABLE translations DROP FOREIGN KEY FK_C6B7DA87D07ED992');
        $this->addSql('DROP TABLE languages');
        $this->addSql('DROP TABLE translation_keys');
        $this->addSql('DROP TABLE translations');
        $this->addSql('ALTER TABLE role_right_names RENAME INDEX uniq_388e8ac94e645a7e TO UNIQ_388E8AC98E85A347');
        $this->addSql('ALTER TABLE roles RENAME INDEX uniq_b63e2ec74e645a7e TO UNIQ_B63E2EC73EF22FDB');

    }

}
