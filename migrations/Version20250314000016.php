<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250314000016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE listed_product (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, shopping_list_id INT NOT NULL, quantity INT NOT NULL, bought SMALLINT NOT NULL, INDEX IDX_17BBE0254584665A (product_id), INDEX IDX_17BBE02523245BF9 (shopping_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE listed_product ADD CONSTRAINT FK_17BBE0254584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE listed_product ADD CONSTRAINT FK_17BBE02523245BF9 FOREIGN KEY (shopping_list_id) REFERENCES shopping_list (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE listed_product DROP FOREIGN KEY FK_17BBE0254584665A');
        $this->addSql('ALTER TABLE listed_product DROP FOREIGN KEY FK_17BBE02523245BF9');
        $this->addSql('DROP TABLE listed_product');
    }
}
