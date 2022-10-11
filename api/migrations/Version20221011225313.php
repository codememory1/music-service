<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011225313 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE subscription_payments_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE transactions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE subscription_payments (id INT NOT NULL, transaction_id INT NOT NULL, subscription_id INT NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_27CC41E2FC0CB0F ON subscription_payments (transaction_id)');
        $this->addSql('CREATE INDEX IDX_27CC41E9A1887DC ON subscription_payments (subscription_id)');
        $this->addSql('COMMENT ON COLUMN subscription_payments.expires_at IS \'Date and time until which the subscription is valid(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN subscription_payments.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE transactions (id INT NOT NULL, buyer_id INT NOT NULL, type VARCHAR(50) NOT NULL, price DOUBLE PRECISION NOT NULL, status VARCHAR(50) NOT NULL, paid_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EAA81A4C6C755722 ON transactions (buyer_id)');
        $this->addSql('COMMENT ON COLUMN transactions.type IS \'Payment type from enumeration PaymentTypeEnum\'');
        $this->addSql('COMMENT ON COLUMN transactions.price IS \'Purchase price in dollars\'');
        $this->addSql('COMMENT ON COLUMN transactions.status IS \'Payment status from enumeration PaymentStatusEnum\'');
        $this->addSql('COMMENT ON COLUMN transactions.paid_at IS \'Date of successful payment(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN transactions.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN transactions.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE subscription_payments ADD CONSTRAINT FK_27CC41E2FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transactions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription_payments ADD CONSTRAINT FK_27CC41E9A1887DC FOREIGN KEY (subscription_id) REFERENCES subscriptions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C6C755722 FOREIGN KEY (buyer_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription_payments DROP CONSTRAINT FK_27CC41E2FC0CB0F');
        $this->addSql('DROP SEQUENCE subscription_payments_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE transactions_id_seq CASCADE');
        $this->addSql('DROP TABLE subscription_payments');
        $this->addSql('DROP TABLE transactions');
    }
}
