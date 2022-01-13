<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220106135004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garbage ADD type VARCHAR(255) NOT NULL, ADD weight DOUBLE PRECISION NOT NULL, DROP recycled_waste, DROP non_recycled_waste');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garbage ADD non_recycled_waste DOUBLE PRECISION NOT NULL, DROP type, CHANGE weight recycled_waste DOUBLE PRECISION NOT NULL');
    }
}
