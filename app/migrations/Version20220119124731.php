<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220119124731 extends AbstractMigration
{

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE role_right_names (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) NOT NULL COMMENT \'A unique key that can be used to check availability\', title_translation_key VARCHAR(255) NOT NULL COMMENT \'Rule name translation key\', UNIQUE INDEX UNIQ_388E8AC98E85A347 (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_rights (id INT AUTO_INCREMENT NOT NULL, role_right_name_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_AA4630B2993BE663 (role_right_name_id), INDEX IDX_AA4630B2D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) NOT NULL COMMENT \'Unique role key against which the role will be checked\', title_translation_key VARCHAR(255) NOT NULL COMMENT \'Role name translation key\', UNIQUE INDEX UNIQ_B63E2EC73EF22FDB (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role_rights ADD CONSTRAINT FK_AA4630B2993BE663 FOREIGN KEY (role_right_name_id) REFERENCES role_right_names (id)');
        $this->addSql('ALTER TABLE role_rights ADD CONSTRAINT FK_AA4630B2D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');

    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {

        $this->addSql('ALTER TABLE role_rights DROP FOREIGN KEY FK_AA4630B2993BE663');
        $this->addSql('ALTER TABLE role_rights DROP FOREIGN KEY FK_AA4630B2D60322AC');
        $this->addSql('DROP TABLE role_right_names');
        $this->addSql('DROP TABLE role_rights');
        $this->addSql('DROP TABLE roles');

    }

}
