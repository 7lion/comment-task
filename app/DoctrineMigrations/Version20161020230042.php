<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161020230042 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
          CREATE TABLE user (
            id INT AUTO_INCREMENT NOT NULL,
            email VARCHAR(100) NOT NULL,
            name VARCHAR(100) NOT NULL,
            createdAt DATETIME NOT NULL,
            UNIQUE INDEX UNIQ_8D93D649E7927C74 (email),
            PRIMARY KEY(id)
          )
          DEFAULT CHARACTER SET utf8
          COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');

        $this->addSql('
          CREATE TABLE comment (
            id INT AUTO_INCREMENT NOT NULL,
            text TEXT NOT NULL,
            userId INT DEFAULT NULL,
            createdAt DATETIME NOT NULL,
            INDEX IDX_9474526C64B64DCC (userId),
            PRIMARY KEY(id)
          )
          DEFAULT CHARACTER SET utf8
          COLLATE utf8_unicode_ci ENGINE = InnoDB');

        $this->addSql('
            ALTER TABLE comment
            ADD CONSTRAINT FK_9474526C64B64DCC
            FOREIGN KEY (userId) REFERENCES user (id)
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C64B64DCC');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE comment');
    }
}
