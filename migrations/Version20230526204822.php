<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230526204822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE packs_avantages ADD packs_id INT NOT NULL');
        $this->addSql('ALTER TABLE packs_avantages ADD CONSTRAINT FK_28B5B09664BB2150 FOREIGN KEY (packs_id) REFERENCES packs (id)');
        $this->addSql('CREATE INDEX IDX_28B5B09664BB2150 ON packs_avantages (packs_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE packs_avantages DROP FOREIGN KEY FK_28B5B09664BB2150');
        $this->addSql('DROP INDEX IDX_28B5B09664BB2150 ON packs_avantages');
        $this->addSql('ALTER TABLE packs_avantages DROP packs_id');
    }
}
