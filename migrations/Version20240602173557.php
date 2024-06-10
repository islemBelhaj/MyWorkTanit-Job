<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602173557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidature (id INT AUTO_INCREMENT NOT NULL, cv VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre_emploi ADD candidature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre_emploi ADD CONSTRAINT FK_132AD0D1B6121583 FOREIGN KEY (candidature_id) REFERENCES candidature (id)');
        $this->addSql('CREATE INDEX IDX_132AD0D1B6121583 ON offre_emploi (candidature_id)');
        $this->addSql('ALTER TABLE user ADD candidature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B6121583 FOREIGN KEY (candidature_id) REFERENCES candidature (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B6121583 ON user (candidature_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre_emploi DROP FOREIGN KEY FK_132AD0D1B6121583');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B6121583');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP INDEX IDX_132AD0D1B6121583 ON offre_emploi');
        $this->addSql('ALTER TABLE offre_emploi DROP candidature_id');
        $this->addSql('DROP INDEX IDX_8D93D649B6121583 ON user');
        $this->addSql('ALTER TABLE user DROP candidature_id');
    }
}
