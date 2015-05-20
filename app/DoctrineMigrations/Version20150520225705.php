<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150520225705 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE server (uid VARCHAR(255) NOT NULL COMMENT \'(DC2Type:guid)\', ip VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, os VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(uid)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, thumb VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE snapshot (id INT AUTO_INCREMENT NOT NULL, server_uid VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:guid)\', timestamp VARCHAR(255) NOT NULL, cpuCount VARCHAR(255) DEFAULT NULL, cpuLoadMin1 VARCHAR(255) DEFAULT NULL, cpuLoadMin5 VARCHAR(255) DEFAULT NULL, cpuLoadMin15 VARCHAR(255) DEFAULT NULL, memoryTotal VARCHAR(255) DEFAULT NULL, memoryUsed VARCHAR(255) DEFAULT NULL, memoryFree VARCHAR(255) DEFAULT NULL, memoryBuffersCacheUsed VARCHAR(255) DEFAULT NULL, memoryBuffersCacheFree VARCHAR(255) DEFAULT NULL, memorySwapTotal VARCHAR(255) DEFAULT NULL, memorySwapUsed VARCHAR(255) DEFAULT NULL, memorySwapFree VARCHAR(255) DEFAULT NULL, diskTotal VARCHAR(255) DEFAULT NULL, diskUsed VARCHAR(255) DEFAULT NULL, diskFree VARCHAR(255) DEFAULT NULL, INDEX IDX_2C4D15356D520C5C (server_uid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE process (id INT AUTO_INCREMENT NOT NULL, snapshot_id INT DEFAULT NULL, user VARCHAR(255) NOT NULL, command VARCHAR(255) NOT NULL, percentCpu VARCHAR(255) NOT NULL, memoryUsed VARCHAR(255) NOT NULL, INDEX IDX_861D18967B39395E (snapshot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, githubId VARCHAR(255) DEFAULT NULL, preferedUid VARCHAR(255) DEFAULT NULL, preferedGid VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE snapshot ADD CONSTRAINT FK_2C4D15356D520C5C FOREIGN KEY (server_uid) REFERENCES server (uid)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D18967B39395E FOREIGN KEY (snapshot_id) REFERENCES snapshot (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE snapshot DROP FOREIGN KEY FK_2C4D15356D520C5C');
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D18967B39395E');
        $this->addSql('DROP TABLE server');
        $this->addSql('DROP TABLE app');
        $this->addSql('DROP TABLE snapshot');
        $this->addSql('DROP TABLE process');
        $this->addSql('DROP TABLE user');
    }
}
