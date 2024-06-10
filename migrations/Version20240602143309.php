<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602143309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(50) NOT NULL, ADD prenom VARCHAR(50) NOT NULL, ADD logo VARCHAR(50) DEFAULT NULL, ADD identfiant_unique INT DEFAULT NULL, ADD telephone INT DEFAULT NULL, ADD nom_entreprise VARCHAR(50) DEFAULT NULL, ADD role VARCHAR(50) NOT NULL, ADD civilite VARCHAR(50) DEFAULT NULL, ADD secteur_activite VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP nom, DROP prenom, DROP logo, DROP identfiant_unique, DROP telephone, DROP nom_entreprise, DROP role, DROP civilite, DROP secteur_activite');
    }
}
