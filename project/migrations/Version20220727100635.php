<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220727100635 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE author (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE file (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, filename VARCHAR(255) NOT NULL, size INTEGER NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, format VARCHAR(255) DEFAULT NULL, duration INTEGER DEFAULT NULL, pages_number INTEGER DEFAULT NULL, orientation VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_8C9F3610F675F31B ON file (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE file');
    }
}
