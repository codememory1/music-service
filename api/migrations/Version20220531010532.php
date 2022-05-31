<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220531010532 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE subscription_permission_keys_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subscription_permissions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subscriptions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE subscription_permission_keys (id INT NOT NULL, key VARCHAR(255) NOT NULL, title_translation_key VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7963D8CB8A90ABA9 ON subscription_permission_keys (key)');
        $this->addSql('COMMENT ON COLUMN subscription_permission_keys.key IS \'Unique key to identify permissions\'');
        $this->addSql('COMMENT ON COLUMN subscription_permission_keys.title_translation_key IS \'Name in view of the translation key\'');
        $this->addSql('COMMENT ON COLUMN subscription_permission_keys.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN subscription_permission_keys.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE subscription_permissions (id INT NOT NULL, subscription_id INT NOT NULL, subscription_permission_key_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_10F7BCF89A1887DC ON subscription_permissions (subscription_id)');
        $this->addSql('CREATE INDEX IDX_10F7BCF82E68F5D4 ON subscription_permissions (subscription_permission_key_id)');
        $this->addSql('COMMENT ON COLUMN subscription_permissions.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN subscription_permissions.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE subscriptions (id INT NOT NULL, key VARCHAR(255) NOT NULL, title_translation_key VARCHAR(255) NOT NULL, description_translation_key VARCHAR(255) NOT NULL, old_price DOUBLE PRECISION DEFAULT NULL, price DOUBLE PRECISION NOT NULL, is_recommend BOOLEAN NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4778A018A90ABA9 ON subscriptions (key)');
        $this->addSql('COMMENT ON COLUMN subscriptions.key IS \'Unique subscription key for identification\'');
        $this->addSql('COMMENT ON COLUMN subscriptions.title_translation_key IS \'Name in the form of a translation key\'');
        $this->addSql('COMMENT ON COLUMN subscriptions.description_translation_key IS \'Description in the form of a translation key\'');
        $this->addSql('COMMENT ON COLUMN subscriptions.old_price IS \'Old subscription price\'');
        $this->addSql('COMMENT ON COLUMN subscriptions.price IS \'Subscription sale price\'');
        $this->addSql('COMMENT ON COLUMN subscriptions.is_recommend IS \'Whether to recommend this subscription\'');
        $this->addSql('COMMENT ON COLUMN subscriptions.status IS \'Subscription status from SubscriptionStatusEnum\'');
        $this->addSql('COMMENT ON COLUMN subscriptions.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN subscriptions.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE subscription_permissions ADD CONSTRAINT FK_10F7BCF89A1887DC FOREIGN KEY (subscription_id) REFERENCES subscriptions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription_permissions ADD CONSTRAINT FK_10F7BCF82E68F5D4 FOREIGN KEY (subscription_permission_key_id) REFERENCES subscription_permission_keys (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE password_resets ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE password_resets ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE password_resets ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE users ADD subscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ALTER password TYPE TEXT');
        $this->addSql('ALTER TABLE users ALTER password DROP DEFAULT');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E99A1887DC FOREIGN KEY (subscription_id) REFERENCES subscriptions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1483A5E99A1887DC ON users (subscription_id)');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription_permissions DROP CONSTRAINT FK_10F7BCF82E68F5D4');
        $this->addSql('ALTER TABLE subscription_permissions DROP CONSTRAINT FK_10F7BCF89A1887DC');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E99A1887DC');
        $this->addSql('DROP SEQUENCE subscription_permission_keys_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subscription_permissions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subscriptions_id_seq CASCADE');
        $this->addSql('DROP TABLE subscription_permission_keys');
        $this->addSql('DROP TABLE subscription_permissions');
        $this->addSql('DROP TABLE subscriptions');
        $this->addSql('DROP INDEX IDX_1483A5E99A1887DC');
        $this->addSql('ALTER TABLE users DROP subscription_id');
        $this->addSql('ALTER TABLE users ALTER password TYPE TEXT');
        $this->addSql('ALTER TABLE users ALTER password DROP DEFAULT');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE account_activation_codes ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE password_resets ALTER ttl TYPE CHAR(10)');
        $this->addSql('ALTER TABLE password_resets ALTER ttl DROP DEFAULT');
        $this->addSql('ALTER TABLE password_resets ALTER ttl TYPE CHAR(10)');
    }
}
