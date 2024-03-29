<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240302135503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materials ADD vat_id INT NOT NULL');
        $this->addSql('ALTER TABLE materials ADD CONSTRAINT FK_9B1716B5B5B63A6B FOREIGN KEY (vat_id) REFERENCES VATs (id)');
        $this->addSql('CREATE INDEX IDX_9B1716B5B5B63A6B ON materials (vat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materials DROP FOREIGN KEY FK_9B1716B5B5B63A6B');
        $this->addSql('DROP INDEX IDX_9B1716B5B5B63A6B ON materials');
        $this->addSql('ALTER TABLE materials DROP vat_id');
    }
}
