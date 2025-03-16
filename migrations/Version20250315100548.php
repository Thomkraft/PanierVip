<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250315100548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE listed_product (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, bought SMALLINT NOT NULL, INDEX IDX_17BBE0254584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE listed_product ADD CONSTRAINT FK_17BBE0254584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE quantity DROP FOREIGN KEY FK_9FF31636E00EE68D');
        $this->addSql('ALTER TABLE shopping_list_quantity DROP FOREIGN KEY FK_934BCD417E8B4AFC');
        $this->addSql('ALTER TABLE shopping_list_quantity DROP FOREIGN KEY FK_934BCD4123245BF9');
        $this->addSql('DROP TABLE quantity');
        $this->addSql('DROP TABLE shopping_list_quantity');
        $this->addSql('ALTER TABLE product CHANGE weight weight INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quantity (id INT AUTO_INCREMENT NOT NULL, id_product_id INT NOT NULL, quantity INT NOT NULL, bought TINYINT(1) NOT NULL, INDEX IDX_9FF31636E00EE68D (id_product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE shopping_list_quantity (shopping_list_id INT NOT NULL, quantity_id INT NOT NULL, INDEX IDX_934BCD4123245BF9 (shopping_list_id), INDEX IDX_934BCD417E8B4AFC (quantity_id), PRIMARY KEY(shopping_list_id, quantity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quantity ADD CONSTRAINT FK_9FF31636E00EE68D FOREIGN KEY (id_product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE shopping_list_quantity ADD CONSTRAINT FK_934BCD417E8B4AFC FOREIGN KEY (quantity_id) REFERENCES quantity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shopping_list_quantity ADD CONSTRAINT FK_934BCD4123245BF9 FOREIGN KEY (shopping_list_id) REFERENCES shopping_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE listed_product DROP FOREIGN KEY FK_17BBE0254584665A');
        $this->addSql('DROP TABLE listed_product');
        $this->addSql('ALTER TABLE product CHANGE weight weight TINYINT(1) NOT NULL');
    }
}
