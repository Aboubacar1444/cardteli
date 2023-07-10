<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615162901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes ADD espaces_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CA3C3180A FOREIGN KEY (espaces_id) REFERENCES espaces (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_35D4282CA3C3180A ON commandes (espaces_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282CA3C3180A');
        $this->addSql('DROP INDEX UNIQ_35D4282CA3C3180A ON commandes');
        $this->addSql('ALTER TABLE commandes DROP espaces_id');
    }
}
