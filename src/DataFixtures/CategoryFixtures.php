<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoriesData = [
            ['name' => 'Fruits'],
            ['name' => 'Produits laitiers'],
            ['name' => 'Boulangerie'],
            ['name' => 'Viandes'],
            ['name' => 'Épicerie'],
            ['name' => 'Fromages'],
            ['name' => 'Boissons'],
            ['name' => 'Confiseries'],
        ];

        foreach ($categoriesData as $index => $data) {
            $category = new Category();
            $category->setName($data['name']);
            $manager->persist($category);

            // Add reference for each category
            $this->addReference('category_' . ($index + 1), $category);
        }

        $manager->flush();
    }
}