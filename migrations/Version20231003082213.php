<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231003082213 extends AbstractMigration
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE week_subject DROP CONSTRAINT FK_9D8444DC86F3B2F');
        $this->addSql('ALTER TABLE week_subject DROP CONSTRAINT FK_9D8444D23EDC87');
        $this->addSql('DROP TABLE week_subject');
    }
}
