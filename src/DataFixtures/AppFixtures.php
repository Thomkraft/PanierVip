<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $articlesData = [
            ['Pain Complet', 1.20, 0.5, 'Boulangerie'],
            ['Lait Demi-Écrémé', 0.90, 1.0, 'Produits Laitiers'],
            ['Pâtes Complètes', 0.85, 0.5, 'Épicerie'],
            ['Riz Basmati', 1.50, 1.0, 'Épicerie'],
            ['Jus d\'Orange', 2.00, 1.0, 'Boissons'],
            ['Yaourt Nature', 0.60, 0.125, 'Produits Laitiers'],
            ['Tomates Cerises', 1.80, 0.25, 'Fruits et Légumes'],
            ['Poulet Fermier', 5.00, 1.0, 'Viandes'],
            ['Saumon Fumé', 3.50, 0.2, 'Poissons'],
            ['Fromage de Chèvre', 2.50, 0.2, 'Fromages'],
            ['Céréales Bio', 2.99, 0.5, 'Petit-Déjeuner'],
            ['Beurre Doux', 1.10, 0.25, 'Produits Laitiers'],
            ['Confiture de Fraises', 2.20, 0.35, 'Épicerie Sucrée'],
            ['Chocolat Noir', 1.70, 0.1, 'Épicerie Sucrée'],
            ['Eau Minérale', 0.60, 1.5, 'Boissons'],
            ['Café Moulu', 2.80, 0.25, 'Boissons Chaudes'],
            ['Thé Vert', 2.00, 0.1, 'Boissons Chaudes'],
            ['Pommes Golden', 1.50, 1.0, 'Fruits et Légumes'],
            ['Carottes Bio', 1.20, 1.0, 'Fruits et Légumes'],
            ['Steak Haché', 3.00, 0.2, 'Viandes'],
            ['Filet de Porc', 4.50, 0.5, 'Viandes'],
            ['Crevettes Cuites', 4.00, 0.2, 'Poissons'],
            ['Mozzarella', 1.50, 0.25, 'Fromages'],
            ['Baguette Tradition', 0.90, 0.25, 'Boulangerie'],
            ['Compote de Pommes', 1.30, 0.4, 'Épicerie'],
            ['Huile d\'Olive', 3.50, 0.75, 'Épicerie'],
            ['Vinaigre Balsamique', 2.00, 0.25, 'Épicerie'],
            ['Miel Acacia', 3.00, 0.5, 'Épicerie Sucrée'],
            ['Biscuits Chocolat', 1.50, 0.2, 'Épicerie Sucrée'],
            ['Crème Fraîche', 0.80, 0.2, 'Produits Laitiers'],
            ['Farine Blanche', 0.70, 1.0, 'Épicerie'],
            ['Sucre Blanc', 0.90, 1.0, 'Épicerie'],
            ['Sel Fin', 0.50, 0.5, 'Épicerie'],
            ['Poivre Noir', 1.00, 0.05, 'Épicerie'],
            ['Saucisson Sec', 3.00, 0.25, 'Charcuterie'],
            ['Jambon Blanc', 2.50, 0.2, 'Charcuterie'],
            ['Pizza Margherita', 3.50, 0.5, 'Plats Préparés'],
            ['Quiche Lorraine', 2.80, 0.4, 'Plats Préparés'],
            ['Soupe de Légumes', 1.50, 0.5, 'Conserves'],
            ['Haricots Verts', 1.20, 0.4, 'Conserves'],
            ['Maïs Doux', 1.00, 0.4, 'Conserves'],
            ['Chips Nature', 1.50, 0.2, 'Snacks'],
            ['Barres Céréales', 1.80, 0.15, 'Snacks'],
            ['Yaourt aux Fruits', 0.70, 0.125, 'Produits Laitiers'],
            ['Fromage Blanc', 0.90, 0.5, 'Produits Laitiers'],
            ['Croissants', 1.00, 0.25, 'Boulangerie'],
            ['Pain de Mie', 1.50, 0.5, 'Boulangerie'],
            ['Concombre', 0.80, 0.3, 'Fruits et Légumes'],
            ['Poivron Rouge', 1.20, 0.25, 'Fruits et Légumes'],
            ['Côtes de Bœuf', 8.00, 0.5, 'Viandes'],
            ['Filet de Cabillaud', 5.00, 0.3, 'Poissons'],
        ];

        foreach ($articlesData as $data) {
            $article = new Article();
            $article->setName($data[0]);
            $article->setPrice($data[1]);
            $article->setWeight($data[2]);
            $article->setCategory($data[3]);
            $manager->persist($article);
        }

        $manager->flush();
    }
}
