<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200813130203 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE anotacion (id INT AUTO_INCREMENT NOT NULL, informe_id INT NOT NULL, campo_id INT NOT NULL, observaciones LONGTEXT DEFAULT NULL, imagen VARCHAR(2000) DEFAULT NULL, INDEX IDX_7958D9383138CEF (informe_id), INDEX IDX_7958D93A17A385C (campo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE anotaciones (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE anotacion ADD CONSTRAINT FK_7958D9383138CEF FOREIGN KEY (informe_id) REFERENCES informe (id)');
        $this->addSql('ALTER TABLE anotacion ADD CONSTRAINT FK_7958D93A17A385C FOREIGN KEY (campo_id) REFERENCES campo (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE anotacion');
        $this->addSql('DROP TABLE anotaciones');
    }
}
