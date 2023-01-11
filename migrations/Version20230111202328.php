<?php

declare(strict_types=1);

namespace Liox\Shop\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111202328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "order" (id UUID NOT NULL, shipping_address JSON NOT NULL, invoicing_address JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "order".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "order".shipping_address IS \'(DC2Type:address)\'');
        $this->addSql('COMMENT ON COLUMN "order".invoicing_address IS \'(DC2Type:address)\'');
        $this->addSql('CREATE TABLE order_item (id UUID NOT NULL, order_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_52EA1F098D9F6D38 ON order_item (order_id)');
        $this->addSql('COMMENT ON COLUMN order_item.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN order_item.order_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE product (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN product.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE product_variant (id UUID NOT NULL, product_id UUID NOT NULL, name VARCHAR(255) NOT NULL, price JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_209AA41D4584665A ON product_variant (product_id)');
        $this->addSql('COMMENT ON COLUMN product_variant.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN product_variant.product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN product_variant.price IS \'(DC2Type:price)\'');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_variant ADD CONSTRAINT FK_209AA41D4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT FK_52EA1F098D9F6D38');
        $this->addSql('ALTER TABLE product_variant DROP CONSTRAINT FK_209AA41D4584665A');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_variant');
    }
}
