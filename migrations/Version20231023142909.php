<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023142909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wish ADD wish_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wish ADD CONSTRAINT FK_D7D174C94C5FF60F FOREIGN KEY (wish_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D7D174C94C5FF60F ON wish (wish_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE wish DROP CONSTRAINT FK_D7D174C94C5FF60F');
        $this->addSql('DROP INDEX IDX_D7D174C94C5FF60F');
        $this->addSql('ALTER TABLE wish DROP wish_user_id');
    }
}
