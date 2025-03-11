<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250311170115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(50) NOT NULL, weight TINYINT(1) NOT NULL, euros INT NOT NULL, centimes INT NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quantity (id INT AUTO_INCREMENT NOT NULL, id_product_id INT NOT NULL, quantity INT NOT NULL, bought TINYINT(1) NOT NULL, INDEX IDX_9FF31636E00EE68D (id_product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_list (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, nb_products INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shopping_list_quantity (shopping_list_id INT NOT NULL, quantity_id INT NOT NULL, INDEX IDX_934BCD4123245BF9 (shopping_list_id), INDEX IDX_934BCD417E8B4AFC (quantity_id), PRIMARY KEY(shopping_list_id, quantity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE quantity ADD CONSTRAINT FK_9FF31636E00EE68D FOREIGN KEY (id_product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE shopping_list_quantity ADD CONSTRAINT FK_934BCD4123245BF9 FOREIGN KEY (shopping_list_id) REFERENCES shopping_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shopping_list_quantity ADD CONSTRAINT FK_934BCD417E8B4AFC FOREIGN KEY (quantity_id) REFERENCES quantity (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE quantity DROP FOREIGN KEY FK_9FF31636E00EE68D');
        $this->addSql('ALTER TABLE shopping_list_quantity DROP FOREIGN KEY FK_934BCD4123245BF9');
        $this->addSql('ALTER TABLE shopping_list_quantity DROP FOREIGN KEY FK_934BCD417E8B4AFC');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE quantity');
        $this->addSql('DROP TABLE shopping_list');
        $this->addSql('DROP TABLE shopping_list_quantity');
    }
}
