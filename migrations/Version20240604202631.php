<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604202631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offre_emploi (id INT AUTO_INCREMENT NOT NULL, gouvernorat_id INT DEFAULT NULL, titre VARCHAR(50) NOT NULL, nbre_post_vacant INT NOT NULL, remuniration_propose VARCHAR(50) NOT NULL, description_emploi LONGTEXT NOT NULL, experience INT NOT NULL, INDEX IDX_132AD0D175B74E2D (gouvernorat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre_emploi ADD CONSTRAINT FK_132AD0D175B74E2D FOREIGN KEY (gouvernorat_id) REFERENCES gouvernorat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre_emploi DROP FOREIGN KEY FK_132AD0D175B74E2D');
        $this->addSql('DROP TABLE offre_emploi');
    }
}
