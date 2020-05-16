<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200516140928 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE category_id category_id INT NOT NULL, CHANGE type_id type_id INT NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE location location VARCHAR(255) NOT NULL, CHANGE prof prof VARCHAR(255) NOT NULL, CHANGE comp1 comp1 VARCHAR(255) NOT NULL, CHANGE comp2 comp2 VARCHAR(255) NOT NULL, CHANGE comp3 comp3 VARCHAR(255) NOT NULL, CHANGE comp4 comp4 VARCHAR(255) NOT NULL, CHANGE genre genre VARCHAR(255) NOT NULL, CHANGE salary salary INT NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE education education VARCHAR(255) NOT NULL, CHANGE experience experience VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE category_id category_id INT DEFAULT NULL, CHANGE type_id type_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE location location VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE prof prof VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE comp1 comp1 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE comp2 comp2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE comp3 comp3 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE comp4 comp4 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE genre genre VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE salary salary INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE image image VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE education education VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE experience experience VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
