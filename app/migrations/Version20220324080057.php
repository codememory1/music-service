<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324080057 extends AbstractMigration
{

	/**
	 * @param Schema $schema
	 *
	 * @return void
	 */
	public function up(Schema $schema): void
	{

		$this->addSql('CREATE TABLE album_categories (id INT AUTO_INCREMENT NOT NULL, title_translation_key VARCHAR(255) NOT NULL COMMENT \'Album category translation key\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_32F3554D7AEB11FF (title_translation_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE album_types (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) NOT NULL COMMENT \'Unique album type\', title_translation_key VARCHAR(255) NOT NULL COMMENT \'Type name translation key\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_2F88C3164E645A7E (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE albums (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, category_id INT NOT NULL, title VARCHAR(255) NOT NULL COMMENT \'Album name\', photo LONGTEXT NOT NULL COMMENT \'Link to album photo\', tags JSON DEFAULT NULL COMMENT \'Album tags\', auditions INT DEFAULT 0 COMMENT \'Number of full plays\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F4E2474FC54C8C93 (type_id), INDEX IDX_F4E2474F12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE artist_subscribers (id INT AUTO_INCREMENT NOT NULL, artist_id INT NOT NULL, subscriber_id INT NOT NULL, status INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6F7A0EBB7970CF8 (artist_id), INDEX IDX_6F7A0EB7808B1AD (subscriber_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE auth_restrictions (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, devices JSON NOT NULL, operating_systems JSON NOT NULL, browsers JSON NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_99B0B023A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE languages (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(3) NOT NULL COMMENT \'Country code consisting of two to three characters\', title VARCHAR(50) NOT NULL COMMENT \'Language name\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_A0D1537977153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE media_libraries (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, status INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1FBDE627A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE media_library_events (id INT AUTO_INCREMENT NOT NULL, media_library_id INT NOT NULL, name VARCHAR(100) NOT NULL, payload JSON NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_59503B81F4008F43 (media_library_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE media_library_music_events (id INT AUTO_INCREMENT NOT NULL, media_library_music_id INT NOT NULL, name VARCHAR(100) NOT NULL, payload JSON NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_57A6E47E55919232 (media_library_music_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE media_library_musics (id INT AUTO_INCREMENT NOT NULL, media_library_id INT DEFAULT NULL, music_id INT NOT NULL, downloaded_to_device TINYINT(1) NOT NULL, downloaded_to_cache TINYINT(1) NOT NULL, status INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_871D596CF4008F43 (media_library_id), INDEX IDX_871D596C399BBB13 (music_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE music_executors (id INT AUTO_INCREMENT NOT NULL, music_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_488D3DEC399BBB13 (music_id), UNIQUE INDEX UNIQ_488D3DECB7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE music_ratings (id INT AUTO_INCREMENT NOT NULL, music_id INT NOT NULL, user_id INT NOT NULL, type VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A4295B2399BBB13 (music_id), INDEX IDX_A4295B2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE musics (id INT AUTO_INCREMENT NOT NULL, album_id INT NOT NULL, type VARCHAR(50) NOT NULL, name VARCHAR(255) NOT NULL, photo LONGTEXT NOT NULL, full_text LONGTEXT DEFAULT NULL, subtitles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', foul_language TINYINT(1) NOT NULL, published TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8DCA35A71137ABCF (album_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE password_resets (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token LONGTEXT NOT NULL COMMENT \'Password reset token\', executed TINYINT(1) NOT NULL, status INT NOT NULL COMMENT \'Token status\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_9EDAFEA1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE playlist_directories (id INT AUTO_INCREMENT NOT NULL, playlist_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A3D266A06BBD148 (playlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE playlist_events (id INT AUTO_INCREMENT NOT NULL, playlist_id INT NOT NULL, name VARCHAR(100) NOT NULL, payload JSON NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_BCF15B796BBD148 (playlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE playlists (id INT AUTO_INCREMENT NOT NULL, media_library_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5E06116FF4008F43 (media_library_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE role_permission_names (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) NOT NULL COMMENT \'A unique key that can be used to check availability\', title_translation_key VARCHAR(255) NOT NULL COMMENT \'Rule name translation key\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1278BDD94E645A7E (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE role_permissions (id INT AUTO_INCREMENT NOT NULL, role_permission_name_id INT NOT NULL, role_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1FBA94E66B447BCB (role_permission_name_id), INDEX IDX_1FBA94E6D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) NOT NULL COMMENT \'Unique role key against which the role will be checked\', title_translation_key VARCHAR(255) NOT NULL COMMENT \'Role name translation key\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_B63E2EC74E645A7E (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE subscription_permission_names (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) NOT NULL COMMENT \'The unique key of the rule by which access will be checked\', title_translation_key VARCHAR(255) NOT NULL COMMENT \'Rule name translation key\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_57F411B74E645A7E (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE subscription_permissions (id INT AUTO_INCREMENT NOT NULL, subscription_permission_name_id INT NOT NULL, subscription_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_10F7BCF84F5A97AD (subscription_permission_name_id), INDEX IDX_10F7BCF89A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE subscriptions (id INT AUTO_INCREMENT NOT NULL, name_translation_key VARCHAR(255) NOT NULL COMMENT \'Subscription name translation key\', description_translation_key VARCHAR(255) NOT NULL COMMENT \'Subscription description translation key\', price NUMERIC(10, 2) NOT NULL COMMENT \'Subscription price\', old_price NUMERIC(10, 2) DEFAULT NULL COMMENT \'Old subscription price\', status INT NOT NULL COMMENT \'Subscription status, default StatusEnum::ACTIVE\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE translation_keys (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COMMENT \'A unique key by which it will be possible to receive a transfer\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_99ACE7775E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE translations (id INT AUTO_INCREMENT NOT NULL, lang_id INT NOT NULL, translation_key_id INT NOT NULL, translation LONGTEXT NOT NULL COMMENT \'Translation of the key into the specified language\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C6B7DA87B213FA4 (lang_id), INDEX IDX_C6B7DA87D07ED992 (translation_key_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE user_activation_tokens (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, valid VARCHAR(10) NOT NULL COMMENT \'Token lifetime in CronTime format\', token LONGTEXT NOT NULL COMMENT \'Account activation token\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_39C07872A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE user_profile_covers (id INT AUTO_INCREMENT NOT NULL, user_profile_id INT NOT NULL, cover LONGTEXT NOT NULL COMMENT \'Path to cover\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_F322498C6B9DD454 (user_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE user_profile_designs (id INT AUTO_INCREMENT NOT NULL, user_profile_id INT NOT NULL, payload JSON NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_FC7802EE6B9DD454 (user_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE user_profile_photos (id INT AUTO_INCREMENT NOT NULL, user_profile_id INT NOT NULL, photo LONGTEXT NOT NULL COMMENT \'Path to photography\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_BD958E76B9DD454 (user_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE user_profiles (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(50) NOT NULL COMMENT \'User real name\', surname VARCHAR(50) DEFAULT NULL COMMENT \'User real surname\', patronymic VARCHAR(50) DEFAULT NULL COMMENT \'User real patronymic\', birth DATE NOT NULL COMMENT \'User date of birth\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_6BBD6130A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE user_sessions (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, refresh_token LONGTEXT NOT NULL COMMENT \'Refresh token to update the access token\', ip VARCHAR(32) NOT NULL COMMENT \'IP address of authorized user\', country VARCHAR(100) DEFAULT NULL COMMENT \'Authorized user country\', country_code VARCHAR(3) DEFAULT NULL COMMENT \'Country code in two letters\', region VARCHAR(100) DEFAULT NULL COMMENT \'Authorized user region\', city VARCHAR(100) DEFAULT NULL COMMENT \'Authorized user city\', latitude DOUBLE PRECISION DEFAULT NULL COMMENT \'Localization by X\', longitude DOUBLE PRECISION DEFAULT NULL COMMENT \'Localization by Y\', device_model VARCHAR(50) NOT NULL, operating_system VARCHAR(50) NOT NULL, browser VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7AED7913A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE user_subscriptions (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, subscription_id INT NOT NULL, valid_to VARCHAR(255) NOT NULL COMMENT \'Subscription duration in the format 30d 10m, etc.\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_EAF92751A76ED395 (user_id), UNIQUE INDEX UNIQ_EAF927519A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, email VARCHAR(255) NOT NULL COMMENT \'User unique mail\', username VARCHAR(250) NOT NULL COMMENT \'The default username is the truncated mail then the symbol @\', password LONGTEXT NOT NULL COMMENT \'User password hash\', status SMALLINT NOT NULL COMMENT \'User status, not active by default\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), INDEX IDX_1483A5E9D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
		$this->addSql('ALTER TABLE albums ADD CONSTRAINT FK_F4E2474FC54C8C93 FOREIGN KEY (type_id) REFERENCES album_types (id)');
		$this->addSql('ALTER TABLE albums ADD CONSTRAINT FK_F4E2474F12469DE2 FOREIGN KEY (category_id) REFERENCES album_categories (id)');
		$this->addSql('ALTER TABLE artist_subscribers ADD CONSTRAINT FK_6F7A0EBB7970CF8 FOREIGN KEY (artist_id) REFERENCES users (id)');
		$this->addSql('ALTER TABLE artist_subscribers ADD CONSTRAINT FK_6F7A0EB7808B1AD FOREIGN KEY (subscriber_id) REFERENCES users (id)');
		$this->addSql('ALTER TABLE auth_restrictions ADD CONSTRAINT FK_99B0B023A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
		$this->addSql('ALTER TABLE media_libraries ADD CONSTRAINT FK_1FBDE627A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
		$this->addSql('ALTER TABLE media_library_events ADD CONSTRAINT FK_59503B81F4008F43 FOREIGN KEY (media_library_id) REFERENCES media_libraries (id)');
		$this->addSql('ALTER TABLE media_library_music_events ADD CONSTRAINT FK_57A6E47E55919232 FOREIGN KEY (media_library_music_id) REFERENCES media_library_musics (id)');
		$this->addSql('ALTER TABLE media_library_musics ADD CONSTRAINT FK_871D596CF4008F43 FOREIGN KEY (media_library_id) REFERENCES media_libraries (id)');
		$this->addSql('ALTER TABLE media_library_musics ADD CONSTRAINT FK_871D596C399BBB13 FOREIGN KEY (music_id) REFERENCES musics (id)');
		$this->addSql('ALTER TABLE music_executors ADD CONSTRAINT FK_488D3DEC399BBB13 FOREIGN KEY (music_id) REFERENCES musics (id)');
		$this->addSql('ALTER TABLE music_executors ADD CONSTRAINT FK_488D3DECB7970CF8 FOREIGN KEY (artist_id) REFERENCES users (id)');
		$this->addSql('ALTER TABLE music_ratings ADD CONSTRAINT FK_A4295B2399BBB13 FOREIGN KEY (music_id) REFERENCES musics (id)');
		$this->addSql('ALTER TABLE music_ratings ADD CONSTRAINT FK_A4295B2A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
		$this->addSql('ALTER TABLE musics ADD CONSTRAINT FK_8DCA35A71137ABCF FOREIGN KEY (album_id) REFERENCES albums (id)');
		$this->addSql('ALTER TABLE password_resets ADD CONSTRAINT FK_9EDAFEA1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
		$this->addSql('ALTER TABLE playlist_directories ADD CONSTRAINT FK_A3D266A06BBD148 FOREIGN KEY (playlist_id) REFERENCES playlists (id)');
		$this->addSql('ALTER TABLE playlist_events ADD CONSTRAINT FK_BCF15B796BBD148 FOREIGN KEY (playlist_id) REFERENCES playlists (id)');
		$this->addSql('ALTER TABLE playlists ADD CONSTRAINT FK_5E06116FF4008F43 FOREIGN KEY (media_library_id) REFERENCES media_libraries (id)');
		$this->addSql('ALTER TABLE role_permissions ADD CONSTRAINT FK_1FBA94E66B447BCB FOREIGN KEY (role_permission_name_id) REFERENCES role_permission_names (id)');
		$this->addSql('ALTER TABLE role_permissions ADD CONSTRAINT FK_1FBA94E6D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
		$this->addSql('ALTER TABLE subscription_permissions ADD CONSTRAINT FK_10F7BCF84F5A97AD FOREIGN KEY (subscription_permission_name_id) REFERENCES subscription_permission_names (id)');
		$this->addSql('ALTER TABLE subscription_permissions ADD CONSTRAINT FK_10F7BCF89A1887DC FOREIGN KEY (subscription_id) REFERENCES subscriptions (id)');
		$this->addSql('ALTER TABLE translations ADD CONSTRAINT FK_C6B7DA87B213FA4 FOREIGN KEY (lang_id) REFERENCES languages (id)');
		$this->addSql('ALTER TABLE translations ADD CONSTRAINT FK_C6B7DA87D07ED992 FOREIGN KEY (translation_key_id) REFERENCES translation_keys (id)');
		$this->addSql('ALTER TABLE user_activation_tokens ADD CONSTRAINT FK_39C07872A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
		$this->addSql('ALTER TABLE user_profile_covers ADD CONSTRAINT FK_F322498C6B9DD454 FOREIGN KEY (user_profile_id) REFERENCES user_profiles (id)');
		$this->addSql('ALTER TABLE user_profile_designs ADD CONSTRAINT FK_FC7802EE6B9DD454 FOREIGN KEY (user_profile_id) REFERENCES user_profiles (id)');
		$this->addSql('ALTER TABLE user_profile_photos ADD CONSTRAINT FK_BD958E76B9DD454 FOREIGN KEY (user_profile_id) REFERENCES user_profiles (id)');
		$this->addSql('ALTER TABLE user_profiles ADD CONSTRAINT FK_6BBD6130A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
		$this->addSql('ALTER TABLE user_sessions ADD CONSTRAINT FK_7AED7913A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
		$this->addSql('ALTER TABLE user_subscriptions ADD CONSTRAINT FK_EAF92751A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
		$this->addSql('ALTER TABLE user_subscriptions ADD CONSTRAINT FK_EAF927519A1887DC FOREIGN KEY (subscription_id) REFERENCES subscriptions (id)');
		$this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');

	}

	/**
	 * @param Schema $schema
	 *
	 * @return void
	 */
	public function down(Schema $schema): void
	{

		// this down() migration is auto-generated, please modify it to your needs
		$this->addSql('ALTER TABLE albums DROP FOREIGN KEY FK_F4E2474F12469DE2');
		$this->addSql('ALTER TABLE albums DROP FOREIGN KEY FK_F4E2474FC54C8C93');
		$this->addSql('ALTER TABLE musics DROP FOREIGN KEY FK_8DCA35A71137ABCF');
		$this->addSql('ALTER TABLE translations DROP FOREIGN KEY FK_C6B7DA87B213FA4');
		$this->addSql('ALTER TABLE media_library_events DROP FOREIGN KEY FK_59503B81F4008F43');
		$this->addSql('ALTER TABLE media_library_musics DROP FOREIGN KEY FK_871D596CF4008F43');
		$this->addSql('ALTER TABLE playlists DROP FOREIGN KEY FK_5E06116FF4008F43');
		$this->addSql('ALTER TABLE media_library_music_events DROP FOREIGN KEY FK_57A6E47E55919232');
		$this->addSql('ALTER TABLE media_library_musics DROP FOREIGN KEY FK_871D596C399BBB13');
		$this->addSql('ALTER TABLE music_executors DROP FOREIGN KEY FK_488D3DEC399BBB13');
		$this->addSql('ALTER TABLE music_ratings DROP FOREIGN KEY FK_A4295B2399BBB13');
		$this->addSql('ALTER TABLE playlist_directories DROP FOREIGN KEY FK_A3D266A06BBD148');
		$this->addSql('ALTER TABLE playlist_events DROP FOREIGN KEY FK_BCF15B796BBD148');
		$this->addSql('ALTER TABLE role_permissions DROP FOREIGN KEY FK_1FBA94E66B447BCB');
		$this->addSql('ALTER TABLE role_permissions DROP FOREIGN KEY FK_1FBA94E6D60322AC');
		$this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9D60322AC');
		$this->addSql('ALTER TABLE subscription_permissions DROP FOREIGN KEY FK_10F7BCF84F5A97AD');
		$this->addSql('ALTER TABLE subscription_permissions DROP FOREIGN KEY FK_10F7BCF89A1887DC');
		$this->addSql('ALTER TABLE user_subscriptions DROP FOREIGN KEY FK_EAF927519A1887DC');
		$this->addSql('ALTER TABLE translations DROP FOREIGN KEY FK_C6B7DA87D07ED992');
		$this->addSql('ALTER TABLE user_profile_covers DROP FOREIGN KEY FK_F322498C6B9DD454');
		$this->addSql('ALTER TABLE user_profile_designs DROP FOREIGN KEY FK_FC7802EE6B9DD454');
		$this->addSql('ALTER TABLE user_profile_photos DROP FOREIGN KEY FK_BD958E76B9DD454');
		$this->addSql('ALTER TABLE artist_subscribers DROP FOREIGN KEY FK_6F7A0EBB7970CF8');
		$this->addSql('ALTER TABLE artist_subscribers DROP FOREIGN KEY FK_6F7A0EB7808B1AD');
		$this->addSql('ALTER TABLE auth_restrictions DROP FOREIGN KEY FK_99B0B023A76ED395');
		$this->addSql('ALTER TABLE media_libraries DROP FOREIGN KEY FK_1FBDE627A76ED395');
		$this->addSql('ALTER TABLE music_executors DROP FOREIGN KEY FK_488D3DECB7970CF8');
		$this->addSql('ALTER TABLE music_ratings DROP FOREIGN KEY FK_A4295B2A76ED395');
		$this->addSql('ALTER TABLE password_resets DROP FOREIGN KEY FK_9EDAFEA1A76ED395');
		$this->addSql('ALTER TABLE user_activation_tokens DROP FOREIGN KEY FK_39C07872A76ED395');
		$this->addSql('ALTER TABLE user_profiles DROP FOREIGN KEY FK_6BBD6130A76ED395');
		$this->addSql('ALTER TABLE user_sessions DROP FOREIGN KEY FK_7AED7913A76ED395');
		$this->addSql('ALTER TABLE user_subscriptions DROP FOREIGN KEY FK_EAF92751A76ED395');
		$this->addSql('DROP TABLE album_categories');
		$this->addSql('DROP TABLE album_types');
		$this->addSql('DROP TABLE albums');
		$this->addSql('DROP TABLE artist_subscribers');
		$this->addSql('DROP TABLE auth_restrictions');
		$this->addSql('DROP TABLE languages');
		$this->addSql('DROP TABLE media_libraries');
		$this->addSql('DROP TABLE media_library_events');
		$this->addSql('DROP TABLE media_library_music_events');
		$this->addSql('DROP TABLE media_library_musics');
		$this->addSql('DROP TABLE music_executors');
		$this->addSql('DROP TABLE music_ratings');
		$this->addSql('DROP TABLE musics');
		$this->addSql('DROP TABLE password_resets');
		$this->addSql('DROP TABLE playlist_directories');
		$this->addSql('DROP TABLE playlist_events');
		$this->addSql('DROP TABLE playlists');
		$this->addSql('DROP TABLE role_permission_names');
		$this->addSql('DROP TABLE role_permissions');
		$this->addSql('DROP TABLE roles');
		$this->addSql('DROP TABLE subscription_permission_names');
		$this->addSql('DROP TABLE subscription_permissions');
		$this->addSql('DROP TABLE subscriptions');
		$this->addSql('DROP TABLE translation_keys');
		$this->addSql('DROP TABLE translations');
		$this->addSql('DROP TABLE user_activation_tokens');
		$this->addSql('DROP TABLE user_profile_covers');
		$this->addSql('DROP TABLE user_profile_designs');
		$this->addSql('DROP TABLE user_profile_photos');
		$this->addSql('DROP TABLE user_profiles');
		$this->addSql('DROP TABLE user_sessions');
		$this->addSql('DROP TABLE user_subscriptions');
		$this->addSql('DROP TABLE users');
		$this->addSql('DROP TABLE messenger_messages');

	}

}
