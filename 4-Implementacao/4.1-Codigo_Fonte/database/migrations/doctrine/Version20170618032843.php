<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170618032843 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE preco_diaria (id INT AUTO_INCREMENT NOT NULL, id_tipo INT DEFAULT NULL, mes SMALLINT NOT NULL, preco DOUBLE PRECISION NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_2A8500BDFB0D0145 (id_tipo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE preco_diaria ADD CONSTRAINT FK_2A8500BDFB0D0145 FOREIGN KEY (id_tipo) REFERENCES tipo_quarto (id)');
        $this->addSql('DROP TABLE preco_quarto');
        $this->addSql('ALTER TABLE tipo_quarto ADD preco_promocional DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE preco_quarto (id INT AUTO_INCREMENT NOT NULL, id_tipo INT DEFAULT NULL, mes SMALLINT NOT NULL, preco DOUBLE PRECISION NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_C45AA80DFB0D0145 (id_tipo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE preco_quarto ADD CONSTRAINT FK_C45AA80DFB0D0145 FOREIGN KEY (id_tipo) REFERENCES tipo_quarto (id)');
        $this->addSql('DROP TABLE preco_diaria');
        $this->addSql('ALTER TABLE tipo_quarto DROP preco_promocional');
    }
}
