<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170617195801 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE preco_quarto (id INT AUTO_INCREMENT NOT NULL, id_tipo INT DEFAULT NULL, mes SMALLINT NOT NULL, preco DOUBLE PRECISION NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_C45AA80DFB0D0145 (id_tipo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_quarto (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, capacidade INT NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE preco_quarto ADD CONSTRAINT FK_C45AA80DFB0D0145 FOREIGN KEY (id_tipo) REFERENCES tipo_quarto (id)');
        $this->addSql('ALTER TABLE clientes ADD deleted_at DATETIME DEFAULT NULL, CHANGE nacionalidade nacionalidade INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clientes ADD CONSTRAINT FK_50FE07D7ED24F40F FOREIGN KEY (nacionalidade) REFERENCES paises (id)');
        $this->addSql('CREATE INDEX IDX_50FE07D7ED24F40F ON clientes (nacionalidade)');
        $this->addSql('CREATE INDEX nome_idx ON clientes (nome)');
        $this->addSql('CREATE INDEX email_idx ON clientes (email)');
        $this->addSql('CREATE INDEX telefone_idx ON clientes (telefone)');
        $this->addSql('CREATE INDEX celular_idx ON clientes (celular)');
        $this->addSql('CREATE INDEX dni_idx ON clientes (dni)');
        $this->addSql('CREATE INDEX cpf_idx ON clientes (cpf)');
        $this->addSql('CREATE INDEX nome_idx ON usuarios (nome)');
        $this->addSql('CREATE INDEX email_idx ON usuarios (email)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE preco_quarto DROP FOREIGN KEY FK_C45AA80DFB0D0145');
        $this->addSql('DROP TABLE preco_quarto');
        $this->addSql('DROP TABLE tipo_quarto');
        $this->addSql('ALTER TABLE clientes DROP FOREIGN KEY FK_50FE07D7ED24F40F');
        $this->addSql('DROP INDEX IDX_50FE07D7ED24F40F ON clientes');
        $this->addSql('DROP INDEX nome_idx ON clientes');
        $this->addSql('DROP INDEX email_idx ON clientes');
        $this->addSql('DROP INDEX telefone_idx ON clientes');
        $this->addSql('DROP INDEX celular_idx ON clientes');
        $this->addSql('DROP INDEX dni_idx ON clientes');
        $this->addSql('DROP INDEX cpf_idx ON clientes');
        $this->addSql('ALTER TABLE clientes DROP deleted_at, CHANGE nacionalidade nacionalidade VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('DROP INDEX nome_idx ON usuarios');
        $this->addSql('DROP INDEX email_idx ON usuarios');
    }
}
