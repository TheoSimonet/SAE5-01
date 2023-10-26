<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231026091212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE week_subject (week_id INT NOT NULL, subject_id INT NOT NULL, PRIMARY KEY(week_id, subject_id))');
        $this->addSql('CREATE INDEX IDX_9D8444DC86F3B2F ON week_subject (week_id)');
        $this->addSql('CREATE INDEX IDX_9D8444D23EDC87 ON week_subject (subject_id)');
        $this->addSql('ALTER TABLE week_subject ADD CONSTRAINT FK_9D8444DC86F3B2F FOREIGN KEY (week_id) REFERENCES week (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE week_subject ADD CONSTRAINT FK_9D8444D23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subject_week DROP CONSTRAINT fk_c990ed1b23edc87');
        $this->addSql('ALTER TABLE subject_week DROP CONSTRAINT fk_c990ed1bc86f3b2f');
        $this->addSql('DROP TABLE subject_week');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE subject_week (subject_id INT NOT NULL, week_id INT NOT NULL, PRIMARY KEY(subject_id, week_id))');
        $this->addSql('CREATE INDEX idx_c990ed1bc86f3b2f ON subject_week (week_id)');
        $this->addSql('CREATE INDEX idx_c990ed1b23edc87 ON subject_week (subject_id)');
        $this->addSql('ALTER TABLE subject_week ADD CONSTRAINT fk_c990ed1b23edc87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subject_week ADD CONSTRAINT fk_c990ed1bc86f3b2f FOREIGN KEY (week_id) REFERENCES week (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE week_subject DROP CONSTRAINT FK_9D8444DC86F3B2F');
        $this->addSql('ALTER TABLE week_subject DROP CONSTRAINT FK_9D8444D23EDC87');
        $this->addSql('DROP TABLE week_subject');
    }
}
