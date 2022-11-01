<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220927180638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiche_frais (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, etat_id INT NOT NULL, nbr_jusificatif INT NOT NULL, montant_valide NUMERIC(10, 2) NOT NULL, date_derniere_modif DATE NOT NULL, mois VARCHAR(255) NOT NULL, INDEX IDX_5FC0A6A7A76ED395 (user_id), INDEX IDX_5FC0A6A7D5E86FF (etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_frais_forfaitise (id INT AUTO_INCREMENT NOT NULL, fiche_frais_id INT NOT NULL, type_frais_forfait_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_1809C48ED94F5755 (fiche_frais_id), INDEX IDX_1809C48E2CEFB6EF (type_frais_forfait_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_frais_hors_forfais (id INT AUTO_INCREMENT NOT NULL, fichefrais_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, montant NUMERIC(10, 2) NOT NULL, INDEX IDX_7265F7CED318D763 (fichefrais_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_frais_forfait (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, montant NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, cp VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, date_embauche DATE NOT NULL, old_id VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fiche_frais ADD CONSTRAINT FK_5FC0A6A7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fiche_frais ADD CONSTRAINT FK_5FC0A6A7D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE ligne_frais_forfaitise ADD CONSTRAINT FK_1809C48ED94F5755 FOREIGN KEY (fiche_frais_id) REFERENCES fiche_frais (id)');
        $this->addSql('ALTER TABLE ligne_frais_forfaitise ADD CONSTRAINT FK_1809C48E2CEFB6EF FOREIGN KEY (type_frais_forfait_id) REFERENCES type_frais_forfait (id)');
        $this->addSql('ALTER TABLE ligne_frais_hors_forfais ADD CONSTRAINT FK_7265F7CED318D763 FOREIGN KEY (fichefrais_id) REFERENCES fiche_frais (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche_frais DROP FOREIGN KEY FK_5FC0A6A7A76ED395');
        $this->addSql('ALTER TABLE fiche_frais DROP FOREIGN KEY FK_5FC0A6A7D5E86FF');
        $this->addSql('ALTER TABLE ligne_frais_forfaitise DROP FOREIGN KEY FK_1809C48ED94F5755');
        $this->addSql('ALTER TABLE ligne_frais_forfaitise DROP FOREIGN KEY FK_1809C48E2CEFB6EF');
        $this->addSql('ALTER TABLE ligne_frais_hors_forfais DROP FOREIGN KEY FK_7265F7CED318D763');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE fiche_frais');
        $this->addSql('DROP TABLE ligne_frais_forfaitise');
        $this->addSql('DROP TABLE ligne_frais_hors_forfais');
        $this->addSql('DROP TABLE type_frais_forfait');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
