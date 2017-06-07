<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170529232406 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cidades (id INT NOT NULL, id_estado INT DEFAULT NULL, nome VARCHAR(255) NOT NULL, INDEX IDX_79B94AE76A540E (id_estado), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clientes (id INT AUTO_INCREMENT NOT NULL, id_cidade INT DEFAULT NULL, id_usuario INT DEFAULT NULL, nome VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telefone VARCHAR(255) NOT NULL, celular VARCHAR(255) NOT NULL, profissao VARCHAR(255) NOT NULL, nacionalidade VARCHAR(255) NOT NULL, data_nascimento DATE NOT NULL, dni VARCHAR(255) NOT NULL, cpf VARCHAR(255) NOT NULL, genero CHAR(1) NOT NULL, endereco VARCHAR(255) NOT NULL, observacoes VARCHAR(255) NOT NULL, INDEX IDX_50FE07D74CAF86B1 (id_cidade), INDEX IDX_50FE07D7FCF8192D (id_usuario), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estados (id INT AUTO_INCREMENT NOT NULL, id_pais INT DEFAULT NULL, nome VARCHAR(255) NOT NULL, INDEX IDX_222B2128F57D32FD (id_pais), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paises (id INT NOT NULL, nome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cidades ADD CONSTRAINT FK_79B94AE76A540E FOREIGN KEY (id_estado) REFERENCES estados (id)');
        $this->addSql('ALTER TABLE clientes ADD CONSTRAINT FK_50FE07D74CAF86B1 FOREIGN KEY (id_cidade) REFERENCES cidades (id)');
        $this->addSql('ALTER TABLE clientes ADD CONSTRAINT FK_50FE07D7FCF8192D FOREIGN KEY (id_usuario) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE estados ADD CONSTRAINT FK_222B2128F57D32FD FOREIGN KEY (id_pais) REFERENCES paises (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE clientes DROP FOREIGN KEY FK_50FE07D74CAF86B1');
        $this->addSql('ALTER TABLE cidades DROP FOREIGN KEY FK_79B94AE76A540E');
        $this->addSql('ALTER TABLE estados DROP FOREIGN KEY FK_222B2128F57D32FD');
        $this->addSql('DROP TABLE cidades');
        $this->addSql('DROP TABLE clientes');
        $this->addSql('DROP TABLE estados');
        $this->addSql('DROP TABLE paises');
    }
}
