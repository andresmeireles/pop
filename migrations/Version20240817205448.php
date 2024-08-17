<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240817205448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62534E213CD809FD ON customers (trade_name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A99419435E237E06 ON product_categories (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B3BA5A5A5E237E06 ON products (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A26779F35E237E06 ON regions (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AFFE6BEF5E237E06 ON sellers (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_A99419435E237E06');
        $this->addSql('DROP INDEX UNIQ_A26779F35E237E06');
        $this->addSql('DROP INDEX UNIQ_B3BA5A5A5E237E06');
        $this->addSql('DROP INDEX UNIQ_62534E213CD809FD');
        $this->addSql('DROP INDEX UNIQ_AFFE6BEF5E237E06');
    }
}
