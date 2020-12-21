<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201218082924 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient ADD praticien_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB2391866B FOREIGN KEY (praticien_id) REFERENCES praticien (id)');
        $this->addSql('CREATE INDEX IDX_1ADAD7EB2391866B ON patient (praticien_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE rdv');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB2391866B');
        $this->addSql('DROP INDEX IDX_1ADAD7EB2391866B ON patient');
        $this->addSql('ALTER TABLE patient DROP praticien_id');
    }
}
