<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240913185229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE restaurant_setting (id INT AUTO_INCREMENT NOT NULL, week_opening_time VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, week_closing_time VARCHAR(255) DEFAULT NULL, weekend_opening_time VARCHAR(255) DEFAULT NULL, weekend_closing_time VARCHAR(255) DEFAULT NULL, general_name VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, service_type VARCHAR(255) DEFAULT NULL, reservation_policy LONGTEXT DEFAULT NULL, return_policy LONGTEXT DEFAULT NULL, payment_options JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', cuisine_types LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', breakfast_hours VARCHAR(255) DEFAULT NULL, lunch_hours VARCHAR(255) DEFAULT NULL, dinner_hours VARCHAR(255) DEFAULT NULL, special_menus LONGTEXT DEFAULT NULL, staff_work_hours VARCHAR(255) DEFAULT NULL, staff_contact_details LONGTEXT DEFAULT NULL, emergency_procedures LONGTEXT DEFAULT NULL, staff_access_controls LONGTEXT DEFAULT NULL, indoor_temperature VARCHAR(255) DEFAULT NULL, lighting VARCHAR(255) DEFAULT NULL, current_promotions LONGTEXT DEFAULT NULL, discounts LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE restaurant_setting');
    }
}
