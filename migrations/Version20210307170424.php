<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307170424 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kraken_power (id INT AUTO_INCREMENT NOT NULL, power_id INT NOT NULL, kraken_id INT NOT NULL, max_usage INT NOT NULL, INDEX IDX_B7BA4094AB4FC384 (power_id), INDEX IDX_B7BA40948A9341DD (kraken_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE kraken_power ADD CONSTRAINT FK_B7BA4094AB4FC384 FOREIGN KEY (power_id) REFERENCES power (id)');
        $this->addSql('ALTER TABLE kraken_power ADD CONSTRAINT FK_B7BA40948A9341DD FOREIGN KEY (kraken_id) REFERENCES kraken (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE kraken_power');
    }
}
