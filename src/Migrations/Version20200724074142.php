<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200724074142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE modele_chaussure_taille');
        $this->addSql('ALTER TABLE taille ADD modele_chaussures_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taille ADD CONSTRAINT FK_76508B38F5B0655D FOREIGN KEY (modele_chaussures_id) REFERENCES modele_chaussure (id)');
        $this->addSql('CREATE INDEX IDX_76508B38F5B0655D ON taille (modele_chaussures_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE modele_chaussure_taille (modele_chaussure_id INT NOT NULL, taille_id INT NOT NULL, INDEX IDX_5AFFFE53FF25611A (taille_id), INDEX IDX_5AFFFE5376312859 (modele_chaussure_id), PRIMARY KEY(modele_chaussure_id, taille_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE modele_chaussure_taille ADD CONSTRAINT FK_5AFFFE5376312859 FOREIGN KEY (modele_chaussure_id) REFERENCES modele_chaussure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modele_chaussure_taille ADD CONSTRAINT FK_5AFFFE53FF25611A FOREIGN KEY (taille_id) REFERENCES taille (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taille DROP FOREIGN KEY FK_76508B38F5B0655D');
        $this->addSql('DROP INDEX IDX_76508B38F5B0655D ON taille');
        $this->addSql('ALTER TABLE taille DROP modele_chaussures_id');
    }
}
