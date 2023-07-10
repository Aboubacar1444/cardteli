<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515194808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE template_images (id INT AUTO_INCREMENT NOT NULL, modeles_id INT NOT NULL, images VARCHAR(255) NOT NULL, INDEX IDX_EBF7B798708408C (modeles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE template_images ADD CONSTRAINT FK_EBF7B798708408C FOREIGN KEY (modeles_id) REFERENCES templates_carte_visites (id)');
        $this->addSql('ALTER TABLE templates_carte_visites DROP images');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE template_images DROP FOREIGN KEY FK_EBF7B798708408C');
        $this->addSql('DROP TABLE template_images');
        $this->addSql('ALTER TABLE templates_carte_visites ADD images VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
