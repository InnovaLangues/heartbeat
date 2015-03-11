<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150311153040 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE user DROP prefeeredUID, DROP prefeeredGID');
        $this->addSql('ALTER TABLE server ADD status TINYINT(1) NOT NULL, DROP linuxDashUrl');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE server ADD linuxDashUrl VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP status');
        $this->addSql('ALTER TABLE user ADD prefeeredUID VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD prefeeredGID VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
