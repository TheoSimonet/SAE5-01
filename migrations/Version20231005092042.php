<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231005092042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groups DROP lib');
        $this->addSql('ALTER TABLE subject DROP CONSTRAINT fk_fbce3e7a4a798b6f');
        $this->addSql('DROP INDEX idx_fbce3e7a4a798b6f');
        $this->addSql('ALTER TABLE subject DROP semester_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE groups ADD lib VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE subject ADD semester_id INT NOT NULL');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT fk_fbce3e7a4a798b6f FOREIGN KEY (semester_id) REFERENCES semester (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_fbce3e7a4a798b6f ON subject (semester_id)');
    }
}
