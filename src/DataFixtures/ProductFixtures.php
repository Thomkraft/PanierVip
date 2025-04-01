<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $productsData = [
            ['name' => 'Pommes', 'category_id' => 1, 'weight' => 1000, 'euros' => 2, 'centimes' => 50],
            ['name' => 'Lait', 'category_id' => 2, 'weight' => 1000, 'euros' => 1, 'centimes' => 20],
            ['name' => 'Pain', 'category_id' => 3, 'weight' => 500, 'euros' => 1, 'centimes' => 0],
            ['name' => 'Poulet', 'category_id' => 4, 'weight' => 1200, 'euros' => 6, 'centimes' => 50],
            ['name' => 'Riz', 'category_id' => 5, 'weight' => 1000, 'euros' => 1, 'centimes' => 80],
            ['name' => 'Yaourt Nature', 'category_id' => 2, 'weight' => 125, 'euros' => 0, 'centimes' => 60],
            ['name' => 'Tomates', 'category_id' => 1, 'weight' => 500, 'euros' => 1, 'centimes' => 50],
            ['name' => 'Fromage Cheddar', 'category_id' => 6, 'weight' => 250, 'euros' => 2, 'centimes' => 30],
            ['name' => 'Jus d\'Orange', 'category_id' => 7, 'weight' => 1000, 'euros' => 2, 'centimes' => 10],
            ['name' => 'Chocolat Noir', 'category_id' => 8, 'weight' => 100, 'euros' => 1, 'centimes' => 70],
        ];

        foreach ($productsData as $index=>$data) {
            // Get or create new category
            $category = $this->getReference('category_' . $data['category_id'], Category::class);
            if (!$category) {
                $category = new Category();
                $category->setName('none');
                $manager->persist($category);
            }

            $product = new Product();
            $product->setName($data['name']);
            $product->setCategory($category);
            $product->setWeight($data['weight']);
            $product->setEuros($data['euros']);
            $product->setCentimes($data['centimes']);
            $manager->persist($product);

            // Add reference for each user
            $this->addReference('product_' . ($index + 1), $product);
        }

        $manager->flush();
    }
}
