<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307133000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tentacle ADD kraken_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tentacle ADD CONSTRAINT FK_97815F078A9341DD FOREIGN KEY (kraken_id) REFERENCES kraken (id)');
        $this->addSql('CREATE INDEX IDX_97815F078A9341DD ON tentacle (kraken_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tentacle DROP FOREIGN KEY FK_97815F078A9341DD');
        $this->addSql('DROP INDEX IDX_97815F078A9341DD ON tentacle');
        $this->addSql('ALTER TABLE tentacle DROP kraken_id');
    }
}
