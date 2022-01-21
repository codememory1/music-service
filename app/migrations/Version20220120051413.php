<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120051413 extends AbstractMigration
{

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE user_profile_covers (id INT AUTO_INCREMENT NOT NULL, user_profile_id INT NOT NULL, cover LONGTEXT NOT NULL COMMENT \'Path to cover\', UNIQUE INDEX UNIQ_F322498C6B9DD454 (user_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_profile_photos (id INT AUTO_INCREMENT NOT NULL, user_profile_id INT NOT NULL, photo LONGTEXT NOT NULL COMMENT \'Path to photography\', UNIQUE INDEX UNIQ_BD958E76B9DD454 (user_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_profiles (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(50) NOT NULL COMMENT \'User real name\', surname VARCHAR(50) DEFAULT NULL COMMENT \'User real surname\', patronymic VARCHAR(50) DEFAULT NULL COMMENT \'User real patronymic\', birth DATE NOT NULL COMMENT \'User date of birth\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_6BBD6130A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, email VARCHAR(255) NOT NULL COMMENT \'User unique mail\', username VARCHAR(250) NOT NULL COMMENT \'The default username is the truncated mail then the symbol @\', password LONGTEXT NOT NULL COMMENT \'User password hash\', status SMALLINT NOT NULL COMMENT \'User status, not active by default\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), INDEX IDX_1483A5E9D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_profile_covers ADD CONSTRAINT FK_F322498C6B9DD454 FOREIGN KEY (user_profile_id) REFERENCES user_profiles (id)');
        $this->addSql('ALTER TABLE user_profile_photos ADD CONSTRAINT FK_BD958E76B9DD454 FOREIGN KEY (user_profile_id) REFERENCES user_profiles (id)');
        $this->addSql('ALTER TABLE user_profiles ADD CONSTRAINT FK_6BBD6130A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');

    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {

        $this->addSql('ALTER TABLE user_profile_covers DROP FOREIGN KEY FK_F322498C6B9DD454');
        $this->addSql('ALTER TABLE user_profile_photos DROP FOREIGN KEY FK_BD958E76B9DD454');
        $this->addSql('ALTER TABLE user_profiles DROP FOREIGN KEY FK_6BBD6130A76ED395');
        $this->addSql('DROP TABLE user_profile_covers');
        $this->addSql('DROP TABLE user_profile_photos');
        $this->addSql('DROP TABLE user_profiles');
        $this->addSql('DROP TABLE users');

    }

}
