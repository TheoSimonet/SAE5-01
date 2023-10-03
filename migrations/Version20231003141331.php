<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231003141331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subject ADD COLUMN first_week_integer INTEGER');
        $this->addSql('ALTER TABLE subject ADD COLUMN last_week_integer INTEGER');

        // 2. Mettez à jour les nouvelles colonnes
        $this->addSql('UPDATE subject SET first_week_integer = EXTRACT(WEEK FROM first_week), last_week_integer = EXTRACT(WEEK FROM last_week)');

        // 3. Supprimez les anciennes colonnes
        $this->addSql('ALTER TABLE subject DROP COLUMN first_week, DROP COLUMN last_week');

        // 4. (Optionnel) Renommez les nouvelles colonnes
        $this->addSql('ALTER TABLE subject RENAME COLUMN first_week_integer TO first_week');
        $this->addSql('ALTER TABLE subject RENAME COLUMN last_week_integer TO last_week');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE subject ALTER first_week TYPE DATE');
        $this->addSql('ALTER TABLE subject ALTER last_week TYPE DATE');
    }
}
