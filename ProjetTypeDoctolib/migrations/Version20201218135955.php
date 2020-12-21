<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201218135955 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv ADD patient_id INT DEFAULT NULL, ADD praticien_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F866B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F862391866B FOREIGN KEY (praticien_id) REFERENCES praticien (id)');
        $this->addSql('CREATE INDEX IDX_10C31F866B899279 ON rdv (patient_id)');
        $this->addSql('CREATE INDEX IDX_10C31F862391866B ON rdv (praticien_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F866B899279');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F862391866B');
        $this->addSql('DROP INDEX IDX_10C31F866B899279 ON rdv');
        $this->addSql('DROP INDEX IDX_10C31F862391866B ON rdv');
        $this->addSql('ALTER TABLE rdv DROP patient_id, DROP praticien_id');
    }
}
