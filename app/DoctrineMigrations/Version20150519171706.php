<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150519171706 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE serverData (id INT AUTO_INCREMENT NOT NULL, serverId VARCHAR(255) NOT NULL, timestamp VARCHAR(255) NOT NULL, diskTotal VARCHAR(255) DEFAULT NULL, diskFree VARCHAR(255) DEFAULT NULL, cpuCount VARCHAR(255) DEFAULT NULL, cpuLoadMin1 VARCHAR(255) DEFAULT NULL, cpuLoadMin5 VARCHAR(255) DEFAULT NULL, cpuLoadMin15 VARCHAR(255) DEFAULT NULL, memoryTotal VARCHAR(255) DEFAULT NULL, memoryUsed VARCHAR(255) DEFAULT NULL, memoryFree VARCHAR(255) DEFAULT NULL, memoryBuffersCacheUsed VARCHAR(255) DEFAULT NULL, memoryBuffersCacheFree VARCHAR(255) DEFAULT NULL, memorySwapTotal VARCHAR(255) DEFAULT NULL, memorySwapUsed VARCHAR(255) DEFAULT NULL, memorySwapFree VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE serverData');
    }
}
