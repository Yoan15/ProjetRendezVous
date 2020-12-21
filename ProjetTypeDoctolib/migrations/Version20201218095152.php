<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201218095152 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD patient_id INT DEFAULT NULL, ADD praticien_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492391866B FOREIGN KEY (praticien_id) REFERENCES praticien (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6496B899279 ON user (patient_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6492391866B ON user (praticien_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496B899279');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492391866B');
        $this->addSql('DROP INDEX UNIQ_8D93D6496B899279 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D6492391866B ON user');
        $this->addSql('ALTER TABLE user DROP patient_id, DROP praticien_id');
    }
}
