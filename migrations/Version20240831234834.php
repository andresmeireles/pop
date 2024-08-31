<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240831234834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE additionals (id SERIAL NOT NULL, order_id INT NOT NULL, name VARCHAR(255) NOT NULL, value NUMERIC(2, 0) NOT NULL, addition BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_52EC581A8D9F6D38 ON additionals (order_id)');
        $this->addSql('CREATE TABLE customers (id SERIAL NOT NULL, trade_name VARCHAR(255) NOT NULL, cnpj VARCHAR(255) DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, state VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE freights (id SERIAL NOT NULL, product_category_id INT NOT NULL, region_id INT NOT NULL, value NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A620F5D4BE6903FD ON freights (product_category_id)');
        $this->addSql('CREATE INDEX IDX_A620F5D498260155 ON freights (region_id)');
        $this->addSql('CREATE TABLE order_products (id SERIAL NOT NULL, order_id INT NOT NULL, product_id INT NOT NULL, price NUMERIC(10, 0) NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5242B8EB8D9F6D38 ON order_products (order_id)');
        $this->addSql('CREATE INDEX IDX_5242B8EB4584665A ON order_products (product_id)');
        $this->addSql('CREATE TABLE "orders" (id SERIAL NOT NULL, customer_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E52FFDEE9395C3F3 ON "orders" (customer_id)');
        $this->addSql('CREATE TABLE product_categories (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A99419435E237E06 ON product_categories (name)');
        $this->addSql('CREATE TABLE products (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, height VARCHAR(255) NOT NULL, original_value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product_product_category (product_id INT NOT NULL, product_category_id INT NOT NULL, PRIMARY KEY(product_id, product_category_id))');
        $this->addSql('CREATE INDEX IDX_437017AA4584665A ON product_product_category (product_id)');
        $this->addSql('CREATE INDEX IDX_437017AABE6903FD ON product_product_category (product_category_id)');
        $this->addSql('CREATE TABLE regions (id SERIAL NOT NULL, seller_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A26779F35E237E06 ON regions (name)');
        $this->addSql('CREATE INDEX IDX_A26779F38DE820D9 ON regions (seller_id)');
        $this->addSql('CREATE TABLE sellers (id SERIAL NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AFFE6BEF5E237E06 ON sellers (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AFFE6BEFA76ED395 ON sellers (user_id)');
        $this->addSql('CREATE TABLE "users" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "users" (email)');
        $this->addSql('ALTER TABLE additionals ADD CONSTRAINT FK_52EC581A8D9F6D38 FOREIGN KEY (order_id) REFERENCES "orders" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE freights ADD CONSTRAINT FK_A620F5D4BE6903FD FOREIGN KEY (product_category_id) REFERENCES product_categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE freights ADD CONSTRAINT FK_A620F5D498260155 FOREIGN KEY (region_id) REFERENCES regions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_products ADD CONSTRAINT FK_5242B8EB8D9F6D38 FOREIGN KEY (order_id) REFERENCES "orders" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_products ADD CONSTRAINT FK_5242B8EB4584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "orders" ADD CONSTRAINT FK_E52FFDEE9395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_product_category ADD CONSTRAINT FK_437017AA4584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_product_category ADD CONSTRAINT FK_437017AABE6903FD FOREIGN KEY (product_category_id) REFERENCES product_categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE regions ADD CONSTRAINT FK_A26779F38DE820D9 FOREIGN KEY (seller_id) REFERENCES sellers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sellers ADD CONSTRAINT FK_AFFE6BEFA76ED395 FOREIGN KEY (user_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE additionals DROP CONSTRAINT FK_52EC581A8D9F6D38');
        $this->addSql('ALTER TABLE freights DROP CONSTRAINT FK_A620F5D4BE6903FD');
        $this->addSql('ALTER TABLE freights DROP CONSTRAINT FK_A620F5D498260155');
        $this->addSql('ALTER TABLE order_products DROP CONSTRAINT FK_5242B8EB8D9F6D38');
        $this->addSql('ALTER TABLE order_products DROP CONSTRAINT FK_5242B8EB4584665A');
        $this->addSql('ALTER TABLE "orders" DROP CONSTRAINT FK_E52FFDEE9395C3F3');
        $this->addSql('ALTER TABLE product_product_category DROP CONSTRAINT FK_437017AA4584665A');
        $this->addSql('ALTER TABLE product_product_category DROP CONSTRAINT FK_437017AABE6903FD');
        $this->addSql('ALTER TABLE regions DROP CONSTRAINT FK_A26779F38DE820D9');
        $this->addSql('ALTER TABLE sellers DROP CONSTRAINT FK_AFFE6BEFA76ED395');
        $this->addSql('DROP TABLE additionals');
        $this->addSql('DROP TABLE customers');
        $this->addSql('DROP TABLE freights');
        $this->addSql('DROP TABLE order_products');
        $this->addSql('DROP TABLE "orders"');
        $this->addSql('DROP TABLE product_categories');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE product_product_category');
        $this->addSql('DROP TABLE regions');
        $this->addSql('DROP TABLE sellers');
        $this->addSql('DROP TABLE "users"');
    }
}
