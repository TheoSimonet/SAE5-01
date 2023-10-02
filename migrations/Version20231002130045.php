<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231002130045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE period_semester (period_id INT NOT NULL, semester_id INT NOT NULL, PRIMARY KEY(period_id, semester_id))');
        $this->addSql('CREATE INDEX IDX_9273BE8EEC8B7ADE ON period_semester (period_id)');
        $this->addSql('CREATE INDEX IDX_9273BE8E4A798B6F ON period_semester (semester_id)');
        $this->addSql('ALTER TABLE period_semester ADD CONSTRAINT FK_9273BE8EEC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE period_semester ADD CONSTRAINT FK_9273BE8E4A798B6F FOREIGN KEY (semester_id) REFERENCES semester (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE period_semester DROP CONSTRAINT FK_9273BE8EEC8B7ADE');
        $this->addSql('ALTER TABLE period_semester DROP CONSTRAINT FK_9273BE8E4A798B6F');
        $this->addSql('DROP TABLE period_semester');
    }
}
