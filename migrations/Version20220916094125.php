<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916094125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_frais_hors_forfais ADD fichefrais_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_frais_hors_forfais ADD CONSTRAINT FK_7265F7CED318D763 FOREIGN KEY (fichefrais_id) REFERENCES fiche_frais (id)');
        $this->addSql('CREATE INDEX IDX_7265F7CED318D763 ON ligne_frais_hors_forfais (fichefrais_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_frais_hors_forfais DROP FOREIGN KEY FK_7265F7CED318D763');
        $this->addSql('DROP INDEX IDX_7265F7CED318D763 ON ligne_frais_hors_forfais');
        $this->addSql('ALTER TABLE ligne_frais_hors_forfais DROP fichefrais_id');
    }
}
