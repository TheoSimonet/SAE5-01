<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231027114423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subject_nb_group (subject_id INT NOT NULL, nb_group_id INT NOT NULL, PRIMARY KEY(subject_id, nb_group_id))');
        $this->addSql('CREATE INDEX IDX_D22D79BE23EDC87 ON subject_nb_group (subject_id)');
        $this->addSql('CREATE INDEX IDX_D22D79BE8AAA5016 ON subject_nb_group (nb_group_id)');
        $this->addSql('ALTER TABLE subject_nb_group ADD CONSTRAINT FK_D22D79BE23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subject_nb_group ADD CONSTRAINT FK_D22D79BE8AAA5016 FOREIGN KEY (nb_group_id) REFERENCES nbGroups (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE subject_nb_group DROP CONSTRAINT FK_D22D79BE23EDC87');
        $this->addSql('ALTER TABLE subject_nb_group DROP CONSTRAINT FK_D22D79BE8AAA5016');
        $this->addSql('DROP TABLE subject_nb_group');
    }
}
