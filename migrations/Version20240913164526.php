<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240913164526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant_setting ADD week_opening_time VARCHAR(10) NOT NULL, ADD week_closing_time VARCHAR(10) NOT NULL, ADD weekend_opening_time VARCHAR(10) NOT NULL, ADD weekend_closing_time VARCHAR(10) NOT NULL, DROP value, DROP updated_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant_setting ADD value VARCHAR(255) NOT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP week_opening_time, DROP week_closing_time, DROP weekend_opening_time, DROP weekend_closing_time');
    }
}
