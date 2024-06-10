<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602173323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offre_emploi (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) NOT NULL, nbre_post_vacant INT NOT NULL, remuneration_propose INT NOT NULL, description LONGTEXT NOT NULL, experience INT NOT NULL, statut INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_emploi_langue (offre_emploi_id INT NOT NULL, langue_id INT NOT NULL, INDEX IDX_BC334907B08996ED (offre_emploi_id), INDEX IDX_BC3349072AADBACD (langue_id), PRIMARY KEY(offre_emploi_id, langue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre_emploi_langue ADD CONSTRAINT FK_BC334907B08996ED FOREIGN KEY (offre_emploi_id) REFERENCES offre_emploi (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_emploi_langue ADD CONSTRAINT FK_BC3349072AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gouvernorat ADD offre_emploi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gouvernorat ADD CONSTRAINT FK_4457C12BB08996ED FOREIGN KEY (offre_emploi_id) REFERENCES offre_emploi (id)');
        $this->addSql('CREATE INDEX IDX_4457C12BB08996ED ON gouvernorat (offre_emploi_id)');
        $this->addSql('ALTER TABLE niveau_etude ADD offre_emploi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE niveau_etude ADD CONSTRAINT FK_F8B95B42B08996ED FOREIGN KEY (offre_emploi_id) REFERENCES offre_emploi (id)');
        $this->addSql('CREATE INDEX IDX_F8B95B42B08996ED ON niveau_etude (offre_emploi_id)');
        $this->addSql('ALTER TABLE type_emploi ADD offre_emploi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_emploi ADD CONSTRAINT FK_5777DBC2B08996ED FOREIGN KEY (offre_emploi_id) REFERENCES offre_emploi (id)');
        $this->addSql('CREATE INDEX IDX_5777DBC2B08996ED ON type_emploi (offre_emploi_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gouvernorat DROP FOREIGN KEY FK_4457C12BB08996ED');
        $this->addSql('ALTER TABLE niveau_etude DROP FOREIGN KEY FK_F8B95B42B08996ED');
        $this->addSql('ALTER TABLE type_emploi DROP FOREIGN KEY FK_5777DBC2B08996ED');
        $this->addSql('ALTER TABLE offre_emploi_langue DROP FOREIGN KEY FK_BC334907B08996ED');
        $this->addSql('ALTER TABLE offre_emploi_langue DROP FOREIGN KEY FK_BC3349072AADBACD');
        $this->addSql('DROP TABLE offre_emploi');
        $this->addSql('DROP TABLE offre_emploi_langue');
        $this->addSql('DROP INDEX IDX_4457C12BB08996ED ON gouvernorat');
        $this->addSql('ALTER TABLE gouvernorat DROP offre_emploi_id');
        $this->addSql('DROP INDEX IDX_F8B95B42B08996ED ON niveau_etude');
        $this->addSql('ALTER TABLE niveau_etude DROP offre_emploi_id');
        $this->addSql('DROP INDEX IDX_5777DBC2B08996ED ON type_emploi');
        $this->addSql('ALTER TABLE type_emploi DROP offre_emploi_id');
    }
}
