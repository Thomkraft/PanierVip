<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ShoppingList;
use App\Entity\ListedProduct;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ShoppingListFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Assuming UserFixtures creates users with references 'user-0', 'user-1', etc.
        $users = [
            $this->getReference('user_1', User::class),
            $this->getReference('user_2', User::class),
            $this->getReference('user_3', User::class),
            $this->getReference('user_4', User::class),
        ];

        // Create ShoppingList instances and associate them with the Users
        foreach ($users as $index => $user) {
            $shoppingList = new ShoppingList();
            $shoppingList->setName('List ' . ($index + 1));
            $shoppingList->setUtilisateur($user);
            $shoppingList->setNbProducts(3);
            $manager->persist($shoppingList);

            // Create ListedProduct instances and associate them with the ShoppingList
            for ($i = 0; $i < 3; $i++) {
                $product = $this->getReference('product_' . rand(1, 9), Product::class);
                $listedProduct = new ListedProduct();
                $listedProduct->setProduct($product);
                $listedProduct->setQuantity(rand(1, 5));
                $listedProduct->setBought(false);
                $listedProduct->setShoppingList($shoppingList);
                $manager->persist($listedProduct);
            }
        }

        // Persist all the entities
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ProductFixtures::class,
        ];
    }
}
