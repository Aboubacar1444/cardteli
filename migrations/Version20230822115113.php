<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230822115113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE espaces ADD CONSTRAINT FK_280B79E7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE espaces ADD CONSTRAINT FK_280B79E7EEF43008 FOREIGN KEY (site_template_id) REFERENCES site_template (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE espaces DROP FOREIGN KEY FK_280B79E7A76ED395');
        $this->addSql('ALTER TABLE espaces DROP FOREIGN KEY FK_280B79E7EEF43008');
    }
}
