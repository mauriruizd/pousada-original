<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170607233754 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE estados ADD id_pais INT DEFAULT NULL');
        $this->addSql('ALTER TABLE estados ADD CONSTRAINT FK_222B2128F57D32FD FOREIGN KEY (id_pais) REFERENCES paises (id)');
        $this->addSql('CREATE INDEX IDX_222B2128F57D32FD ON estados (id_pais)');
        $this->addSql('ALTER TABLE paises DROP FOREIGN KEY FK_DFAD237B9F5A440B');
        $this->addSql('DROP INDEX IDX_DFAD237B9F5A440B ON paises');
        $this->addSql('ALTER TABLE paises DROP estado_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE estados DROP FOREIGN KEY FK_222B2128F57D32FD');
        $this->addSql('DROP INDEX IDX_222B2128F57D32FD ON estados');
        $this->addSql('ALTER TABLE estados DROP id_pais');
        $this->addSql('ALTER TABLE paises ADD estado_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paises ADD CONSTRAINT FK_DFAD237B9F5A440B FOREIGN KEY (estado_id) REFERENCES estados (id)');
        $this->addSql('CREATE INDEX IDX_DFAD237B9F5A440B ON paises (estado_id)');
    }
}
