<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200518101955 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE category_id category_id INT NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE location location VARCHAR(255) NOT NULL, CHANGE prof prof VARCHAR(255) NOT NULL, CHANGE comp1 comp1 VARCHAR(255) NOT NULL, CHANGE comp2 comp2 VARCHAR(255) NOT NULL, CHANGE comp3 comp3 VARCHAR(255) NOT NULL, CHANGE comp4 comp4 VARCHAR(255) NOT NULL, CHANGE genre genre VARCHAR(255) NOT NULL, CHANGE salary salary INT NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE education education VARCHAR(255) NOT NULL, CHANGE experience experience VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_8d93d649e7927c74 TO UNIQ_2DA17977E7927C74');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_8d93d649f85e0677 TO UNIQ_2DA17977F85E0677');
        $this->addSql('ALTER TABLE user RENAME INDEX idx_8d93d64912469de2 TO IDX_2DA1797712469DE2');
        $this->addSql('ALTER TABLE user RENAME INDEX idx_8d93d649c54c8c93 TO IDX_2DA17977C54C8C93');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE User CHANGE category_id category_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE location location VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE prof prof VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE comp1 comp1 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE comp2 comp2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE comp3 comp3 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE comp4 comp4 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE genre genre VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE salary salary INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE image image VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE education education VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE experience experience VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE User RENAME INDEX idx_2da1797712469de2 TO IDX_8D93D64912469DE2');
        $this->addSql('ALTER TABLE User RENAME INDEX idx_2da17977c54c8c93 TO IDX_8D93D649C54C8C93');
        $this->addSql('ALTER TABLE User RENAME INDEX uniq_2da17977e7927c74 TO UNIQ_8D93D649E7927C74');
        $this->addSql('ALTER TABLE User RENAME INDEX uniq_2da17977f85e0677 TO UNIQ_8D93D649F85E0677');
    }
}
