<?php

declare(strict_types=1);

namespace Liox\Shop\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529120702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create newsletter_subscription table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE newsletter_subscription (id UUID NOT NULL, email VARCHAR(150) NOT NULL, subscribed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A82B55ADE7927C74 ON newsletter_subscription (email)');
        $this->addSql('COMMENT ON COLUMN newsletter_subscription.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN newsletter_subscription.subscribed_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE newsletter_subscription');
    }
}
