<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170619224511 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fotos_quartos (id INT AUTO_INCREMENT NOT NULL, id_quarto INT DEFAULT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_DC9E36EB240849F6 (id_quarto), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manutencao (id INT AUTO_INCREMENT NOT NULL, id_quarto INT DEFAULT NULL, motivo LONGTEXT NOT NULL, data_hora DATETIME NOT NULL, INDEX IDX_6585BD8240849F6 (id_quarto), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promocoes (id INT AUTO_INCREMENT NOT NULL, id_quarto INT DEFAULT NULL, data_inicio DATETIME NOT NULL, data_fim DATETIME DEFAULT NULL, preco DOUBLE PRECISION NOT NULL, INDEX IDX_91B7EA16240849F6 (id_quarto), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quartos (id INT AUTO_INCREMENT NOT NULL, id_tipo_quarto INT DEFAULT NULL, numero VARCHAR(255) NOT NULL, andar INT NOT NULL, em_manutencao TINYINT(1) NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX numero_idx (numero), INDEX tipo_quarto_idx (id_tipo_quarto), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fotos_quartos ADD CONSTRAINT FK_DC9E36EB240849F6 FOREIGN KEY (id_quarto) REFERENCES quartos (id)');
        $this->addSql('ALTER TABLE manutencao ADD CONSTRAINT FK_6585BD8240849F6 FOREIGN KEY (id_quarto) REFERENCES quartos (id)');
        $this->addSql('ALTER TABLE promocoes ADD CONSTRAINT FK_91B7EA16240849F6 FOREIGN KEY (id_quarto) REFERENCES quartos (id)');
        $this->addSql('ALTER TABLE quartos ADD CONSTRAINT FK_9169391B8F94C7F4 FOREIGN KEY (id_tipo_quarto) REFERENCES tipo_quarto (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fotos_quartos DROP FOREIGN KEY FK_DC9E36EB240849F6');
        $this->addSql('ALTER TABLE manutencao DROP FOREIGN KEY FK_6585BD8240849F6');
        $this->addSql('ALTER TABLE promocoes DROP FOREIGN KEY FK_91B7EA16240849F6');
        $this->addSql('DROP TABLE fotos_quartos');
        $this->addSql('DROP TABLE manutencao');
        $this->addSql('DROP TABLE promocoes');
        $this->addSql('DROP TABLE quartos');
    }
}
