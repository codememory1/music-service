<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131200602 extends AbstractMigration
{

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {

        $this->addSql('ALTER TABLE role_rights DROP FOREIGN KEY FK_AA4630B2993BE663');
        $this->addSql('ALTER TABLE subscription_rights DROP FOREIGN KEY FK_C896C98478CF7E0B');
        $this->addSql('CREATE TABLE role_permission_names (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) NOT NULL COMMENT \'A unique key that can be used to check availability\', title_translation_key VARCHAR(255) NOT NULL COMMENT \'Rule name translation key\', UNIQUE INDEX UNIQ_1278BDD94E645A7E (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_permissions (id INT AUTO_INCREMENT NOT NULL, role_permission_name_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_1FBA94E66B447BCB (role_permission_name_id), INDEX IDX_1FBA94E6D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_permission_names (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) NOT NULL COMMENT \'The unique key of the rule by which access will be checked\', title_translation_key VARCHAR(255) NOT NULL COMMENT \'Rule name translation key\', UNIQUE INDEX UNIQ_57F411B74E645A7E (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_permissions (id INT AUTO_INCREMENT NOT NULL, subscription_permission_name_id INT NOT NULL, subscription_id INT NOT NULL, INDEX IDX_10F7BCF84F5A97AD (subscription_permission_name_id), INDEX IDX_10F7BCF89A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role_permissions ADD CONSTRAINT FK_1FBA94E66B447BCB FOREIGN KEY (role_permission_name_id) REFERENCES role_permission_names (id)');
        $this->addSql('ALTER TABLE role_permissions ADD CONSTRAINT FK_1FBA94E6D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
        $this->addSql('ALTER TABLE subscription_permissions ADD CONSTRAINT FK_10F7BCF84F5A97AD FOREIGN KEY (subscription_permission_name_id) REFERENCES subscription_permission_names (id)');
        $this->addSql('ALTER TABLE subscription_permissions ADD CONSTRAINT FK_10F7BCF89A1887DC FOREIGN KEY (subscription_id) REFERENCES subscriptions (id)');
        $this->addSql('DROP TABLE role_right_names');
        $this->addSql('DROP TABLE role_rights');
        $this->addSql('DROP TABLE subscription_right_names');
        $this->addSql('DROP TABLE subscription_rights');

    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {

        $this->addSql('ALTER TABLE role_permissions DROP FOREIGN KEY FK_1FBA94E66B447BCB');
        $this->addSql('ALTER TABLE subscription_permissions DROP FOREIGN KEY FK_10F7BCF84F5A97AD');
        $this->addSql('CREATE TABLE role_right_names (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'A unique key that can be used to check availability\', title_translation_key VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Rule name translation key\', UNIQUE INDEX UNIQ_388E8AC94E645A7E (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE role_rights (id INT AUTO_INCREMENT NOT NULL, role_right_name_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_AA4630B2993BE663 (role_right_name_id), INDEX IDX_AA4630B2D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE subscription_right_names (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'The unique key of the rule by which access will be checked\', title_translation_key VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'Rule name translation key\', UNIQUE INDEX UNIQ_37C3A2D74E645A7E (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE subscription_rights (id INT AUTO_INCREMENT NOT NULL, subscription_right_name_id INT NOT NULL, subscription_id INT NOT NULL, INDEX IDX_C896C98478CF7E0B (subscription_right_name_id), INDEX IDX_C896C9849A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE role_rights ADD CONSTRAINT FK_AA4630B2993BE663 FOREIGN KEY (role_right_name_id) REFERENCES role_right_names (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE role_rights ADD CONSTRAINT FK_AA4630B2D60322AC FOREIGN KEY (role_id) REFERENCES roles (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE subscription_rights ADD CONSTRAINT FK_C896C98478CF7E0B FOREIGN KEY (subscription_right_name_id) REFERENCES subscription_right_names (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE subscription_rights ADD CONSTRAINT FK_C896C9849A1887DC FOREIGN KEY (subscription_id) REFERENCES subscriptions (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE role_permission_names');
        $this->addSql('DROP TABLE role_permissions');
        $this->addSql('DROP TABLE subscription_permission_names');
        $this->addSql('DROP TABLE subscription_permissions');

    }

}
