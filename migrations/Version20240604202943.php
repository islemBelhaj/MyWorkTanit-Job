<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240604202943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offre_emploi_langue (offre_emploi_id INT NOT NULL, langue_id INT NOT NULL, INDEX IDX_BC334907B08996ED (offre_emploi_id), INDEX IDX_BC3349072AADBACD (langue_id), PRIMARY KEY(offre_emploi_id, langue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre_emploi_langue ADD CONSTRAINT FK_BC334907B08996ED FOREIGN KEY (offre_emploi_id) REFERENCES offre_emploi (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_emploi_langue ADD CONSTRAINT FK_BC3349072AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_emploi ADD type_emploi_id INT DEFAULT NULL, ADD niveau_etude_id INT DEFAULT NULL, ADD statut INT NOT NULL');
        $this->addSql('ALTER TABLE offre_emploi ADD CONSTRAINT FK_132AD0D158C77F02 FOREIGN KEY (type_emploi_id) REFERENCES type_emploi (id)');
        $this->addSql('ALTER TABLE offre_emploi ADD CONSTRAINT FK_132AD0D1FEAD13D1 FOREIGN KEY (niveau_etude_id) REFERENCES niveau_etude (id)');
        $this->addSql('CREATE INDEX IDX_132AD0D158C77F02 ON offre_emploi (type_emploi_id)');
        $this->addSql('CREATE INDEX IDX_132AD0D1FEAD13D1 ON offre_emploi (niveau_etude_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre_emploi_langue DROP FOREIGN KEY FK_BC334907B08996ED');
        $this->addSql('ALTER TABLE offre_emploi_langue DROP FOREIGN KEY FK_BC3349072AADBACD');
        $this->addSql('DROP TABLE offre_emploi_langue');
        $this->addSql('ALTER TABLE offre_emploi DROP FOREIGN KEY FK_132AD0D158C77F02');
        $this->addSql('ALTER TABLE offre_emploi DROP FOREIGN KEY FK_132AD0D1FEAD13D1');
        $this->addSql('DROP INDEX IDX_132AD0D158C77F02 ON offre_emploi');
        $this->addSql('DROP INDEX IDX_132AD0D1FEAD13D1 ON offre_emploi');
        $this->addSql('ALTER TABLE offre_emploi DROP type_emploi_id, DROP niveau_etude_id, DROP statut');
    }
}
