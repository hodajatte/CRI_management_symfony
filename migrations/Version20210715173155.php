<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210715173155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, societe_id INT DEFAULT NULL, createur_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, tele VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, evenement VARCHAR(255) NOT NULL, date_visite DATETIME NOT NULL, formation VARCHAR(255) NOT NULL, INDEX IDX_C7440455FCF77503 (societe_id), INDEX IDX_C744045573A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE societe (id INT AUTO_INCREMENT NOT NULL, raison_sociale VARCHAR(255) NOT NULL, source VARCHAR(255) NOT NULL, forme_juridique VARCHAR(255) NOT NULL, secteur_activite VARCHAR(255) NOT NULL, sous_secteur_activite VARCHAR(255) NOT NULL, produit VARCHAR(255) NOT NULL, offre_service VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, gsm VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, site_internet VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455FCF77503 FOREIGN KEY (societe_id) REFERENCES societe (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045573A201E5 FOREIGN KEY (createur_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455FCF77503');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045573A201E5');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE societe');
        $this->addSql('DROP TABLE `user`');
    }
}
