<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200313084316 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE equipo_instalado ADD descripcion VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE equipo_instalado ADD CONSTRAINT FK_606E4CFDE05544A3 FOREIGN KEY (tipo_equipo_id) REFERENCES tipo_equipo (id)');
        $this->addSql('CREATE INDEX IDX_606E4CFDE05544A3 ON equipo_instalado (tipo_equipo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE equipo_instalado DROP FOREIGN KEY FK_606E4CFDE05544A3');
        $this->addSql('DROP INDEX IDX_606E4CFDE05544A3 ON equipo_instalado');
        $this->addSql('ALTER TABLE equipo_instalado DROP descripcion');
    }
}
