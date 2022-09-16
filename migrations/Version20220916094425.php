<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916094425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_frais_forfaitise ADD fiche_frais_id INT NOT NULL, ADD type_frais_forfait_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_frais_forfaitise ADD CONSTRAINT FK_1809C48ED94F5755 FOREIGN KEY (fiche_frais_id) REFERENCES fiche_frais (id)');
        $this->addSql('ALTER TABLE ligne_frais_forfaitise ADD CONSTRAINT FK_1809C48E2CEFB6EF FOREIGN KEY (type_frais_forfait_id) REFERENCES type_frais_forfait (id)');
        $this->addSql('CREATE INDEX IDX_1809C48ED94F5755 ON ligne_frais_forfaitise (fiche_frais_id)');
        $this->addSql('CREATE INDEX IDX_1809C48E2CEFB6EF ON ligne_frais_forfaitise (type_frais_forfait_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_frais_forfaitise DROP FOREIGN KEY FK_1809C48ED94F5755');
        $this->addSql('ALTER TABLE ligne_frais_forfaitise DROP FOREIGN KEY FK_1809C48E2CEFB6EF');
        $this->addSql('DROP INDEX IDX_1809C48ED94F5755 ON ligne_frais_forfaitise');
        $this->addSql('DROP INDEX IDX_1809C48E2CEFB6EF ON ligne_frais_forfaitise');
        $this->addSql('ALTER TABLE ligne_frais_forfaitise DROP fiche_frais_id, DROP type_frais_forfait_id');
    }
}
