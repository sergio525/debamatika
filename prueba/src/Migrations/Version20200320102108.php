<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200320102108 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE variable_informe (id INT AUTO_INCREMENT NOT NULL, informe_id INT NOT NULL, variable_id INT NOT NULL, campo_id INT NOT NULL, valor VARCHAR(255) NOT NULL, INDEX IDX_109158BB83138CEF (informe_id), INDEX IDX_109158BBF3037E8E (variable_id), INDEX IDX_109158BBA17A385C (campo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE variable_informe ADD CONSTRAINT FK_109158BB83138CEF FOREIGN KEY (informe_id) REFERENCES informe (id)');
        $this->addSql('ALTER TABLE variable_informe ADD CONSTRAINT FK_109158BBF3037E8E FOREIGN KEY (variable_id) REFERENCES variable (id)');
        $this->addSql('ALTER TABLE variable_informe ADD CONSTRAINT FK_109158BBA17A385C FOREIGN KEY (campo_id) REFERENCES campo (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE variable_informe');
    }
}
