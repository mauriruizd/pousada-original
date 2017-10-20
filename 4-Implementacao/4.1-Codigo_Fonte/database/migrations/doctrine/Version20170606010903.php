<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170606010903 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE acessos ADD CONSTRAINT FK_6B4B9373FCF8192D FOREIGN KEY (id_usuario) REFERENCES usuarios (id)');
        $this->addSql('CREATE INDEX IDX_6B4B9373FCF8192D ON acessos (id_usuario)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE acessos DROP FOREIGN KEY FK_6B4B9373FCF8192D');
        $this->addSql('DROP INDEX IDX_6B4B9373FCF8192D ON acessos');
    }
}
