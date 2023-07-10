<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607004503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD prenom VARCHAR(30) NOT NULL, ADD nom VARCHAR(30) NOT NULL, ADD telephones INT NOT NULL, ADD adresse VARCHAR(255) DEFAULT NULL, ADD comptes VARCHAR(20) NOT NULL, ADD nom_enteprises VARCHAR(30) DEFAULT NULL, ADD pays VARCHAR(20) NOT NULL, ADD statut TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP prenom, DROP nom, DROP telephones, DROP adresse, DROP comptes, DROP nom_enteprises, DROP pays, DROP statut');
    }
}
