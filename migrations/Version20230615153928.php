<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615153928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE numeros_ussd_relations (id INT AUTO_INCREMENT NOT NULL, numero_id INT NOT NULL, espaces_id INT NOT NULL, INDEX IDX_7DC2D6295D172A78 (numero_id), UNIQUE INDEX UNIQ_7DC2D629A3C3180A (espaces_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE numeros_ussd_relations ADD CONSTRAINT FK_7DC2D6295D172A78 FOREIGN KEY (numero_id) REFERENCES numeros_ussd (id)');
        $this->addSql('ALTER TABLE numeros_ussd_relations ADD CONSTRAINT FK_7DC2D629A3C3180A FOREIGN KEY (espaces_id) REFERENCES espaces (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE numeros_ussd_relations DROP FOREIGN KEY FK_7DC2D6295D172A78');
        $this->addSql('ALTER TABLE numeros_ussd_relations DROP FOREIGN KEY FK_7DC2D629A3C3180A');
        $this->addSql('DROP TABLE numeros_ussd_relations');
    }
}
