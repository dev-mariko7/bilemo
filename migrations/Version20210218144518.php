<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210218144518 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD fk_custom_id INT NOT NULL, ADD lastname VARCHAR(50) NOT NULL, ADD firstname VARCHAR(50) NOT NULL, ADD image LONGTEXT DEFAULT NULL, ADD statut VARCHAR(20) DEFAULT NULL, ADD date_c DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64913B7AA FOREIGN KEY (fk_custom_id) REFERENCES customers (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64913B7AA ON user (fk_custom_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64913B7AA');
        $this->addSql('DROP INDEX IDX_8D93D64913B7AA ON user');
        $this->addSql('ALTER TABLE user DROP fk_custom_id, DROP lastname, DROP firstname, DROP image, DROP statut, DROP date_c');
    }
}
