<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615164057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE espaces ADD commandes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE espaces ADD CONSTRAINT FK_280B79E78BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commandes (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_280B79E78BF5C2E6 ON espaces (commandes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE espaces DROP FOREIGN KEY FK_280B79E78BF5C2E6');
        $this->addSql('DROP INDEX UNIQ_280B79E78BF5C2E6 ON espaces');
        $this->addSql('ALTER TABLE espaces DROP commandes_id');
    }
}
