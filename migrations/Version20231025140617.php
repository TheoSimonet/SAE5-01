<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231025140617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subject_tag (subject_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(subject_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_1B83F74F23EDC87 ON subject_tag (subject_id)');
        $this->addSql('CREATE INDEX IDX_1B83F74FBAD26311 ON subject_tag (tag_id)');
        $this->addSql('ALTER TABLE subject_tag ADD CONSTRAINT FK_1B83F74F23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subject_tag ADD CONSTRAINT FK_1B83F74FBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE subject_tag DROP CONSTRAINT FK_1B83F74F23EDC87');
        $this->addSql('ALTER TABLE subject_tag DROP CONSTRAINT FK_1B83F74FBAD26311');
        $this->addSql('DROP TABLE subject_tag');
    }
}
