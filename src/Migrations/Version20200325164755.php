<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200325164755 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_4FBF094F12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(64) NOT NULL, username VARCHAR(64) NOT NULL, password VARCHAR(64) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, type_id INT NOT NULL, email VARCHAR(64) NOT NULL, username VARCHAR(64) NOT NULL, password VARCHAR(64) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', address VARCHAR(255) NOT NULL, prof VARCHAR(255) NOT NULL, comp1 VARCHAR(255) NOT NULL, comp2 VARCHAR(255) NOT NULL, comp3 VARCHAR(255) NOT NULL, comp4 VARCHAR(255) NOT NULL, salary INT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, UNIQUE INDEX UNIQ_5D9F75A1E7927C74 (email), UNIQUE INDEX UNIQ_5D9F75A1F85E0677 (username), INDEX IDX_5D9F75A112469DE2 (category_id), INDEX IDX_5D9F75A1C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, wage VARCHAR(255) NOT NULL, INDEX IDX_FBD8E0F812469DE2 (category_id), INDEX IDX_FBD8E0F8C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_job (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1C54C8C93 FOREIGN KEY (type_id) REFERENCES type_job (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8C54C8C93 FOREIGN KEY (type_id) REFERENCES type_job (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F12469DE2');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A112469DE2');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F812469DE2');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1C54C8C93');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8C54C8C93');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE type_job');
    }
}
