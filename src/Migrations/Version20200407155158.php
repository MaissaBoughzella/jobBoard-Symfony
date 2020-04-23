<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407155158 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE resume (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, profession VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, rate INT NOT NULL, cv VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP INDEX UNIQ_5D9F75A1F85E0677 ON employee');
        $this->addSql('DROP INDEX UNIQ_5D9F75A1E7927C74 ON employee');
        $this->addSql('ALTER TABLE employee ADD name VARCHAR(255) NOT NULL, ADD image VARCHAR(255) NOT NULL, DROP username, DROP password, DROP roles, CHANGE email email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE job ADD company_id INT NOT NULL, ADD experience INT NOT NULL, ADD offre VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL, ADD req VARCHAR(255) NOT NULL, ADD req2 VARCHAR(255) NOT NULL, ADD req3 VARCHAR(255) NOT NULL, ADD req4 VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_FBD8E0F8979B1AD6 ON job (company_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE resume');
        $this->addSql('ALTER TABLE employee ADD username VARCHAR(64) NOT NULL COLLATE utf8mb4_unicode_ci, ADD password VARCHAR(64) NOT NULL COLLATE utf8mb4_unicode_ci, ADD roles LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', DROP name, DROP image, CHANGE email email VARCHAR(64) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A1F85E0677 ON employee (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A1E7927C74 ON employee (email)');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8979B1AD6');
        $this->addSql('DROP INDEX IDX_FBD8E0F8979B1AD6 ON job');
        $this->addSql('ALTER TABLE job DROP company_id, DROP experience, DROP offre, DROP description, DROP req, DROP req2, DROP req3, DROP req4');
    }
}
