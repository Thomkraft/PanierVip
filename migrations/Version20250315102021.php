<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250315102021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE listed_product ADD shopping_list_id INT NOT NULL');
        $this->addSql('ALTER TABLE listed_product ADD CONSTRAINT FK_17BBE02523245BF9 FOREIGN KEY (shopping_list_id) REFERENCES shopping_list (id)');
        $this->addSql('CREATE INDEX IDX_17BBE02523245BF9 ON listed_product (shopping_list_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE listed_product DROP FOREIGN KEY FK_17BBE02523245BF9');
        $this->addSql('DROP INDEX IDX_17BBE02523245BF9 ON listed_product');
        $this->addSql('ALTER TABLE listed_product DROP shopping_list_id');
    }
}
