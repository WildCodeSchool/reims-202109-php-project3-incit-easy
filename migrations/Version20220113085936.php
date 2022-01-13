<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220113085936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adress (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, street VARCHAR(255) NOT NULL, zipcode VARCHAR(60) NOT NULL, city VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5CECC7BEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adress ADD CONSTRAINT FK_5CECC7BEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE garbage ADD adress_id INT NOT NULL');
        $this->addSql('ALTER TABLE garbage ADD CONSTRAINT FK_5C99346D8486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id)');
        $this->addSql('CREATE INDEX IDX_5C99346D8486F9AC ON garbage (adress_id)');
        $this->addSql('ALTER TABLE user DROP street, DROP zipcode, DROP city');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garbage DROP FOREIGN KEY FK_5C99346D8486F9AC');
        $this->addSql('DROP TABLE adress');
        $this->addSql('DROP INDEX IDX_5C99346D8486F9AC ON garbage');
        $this->addSql('ALTER TABLE garbage DROP adress_id');
        $this->addSql('ALTER TABLE user ADD street VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD zipcode VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD city VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
