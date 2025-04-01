<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            ['email' => 'tom.frumy170@gmail.com', 'pseudo' => 'Tom', 'roles' => [], 'password' => 'nasa', 'is_admin' => 0],
            ['email' => 'minh@ad.fr', 'pseudo' => 'Admin', 'roles' => [], 'password' => 'admin', 'is_admin' => 1],
            ['email' => 'thomas.kng69@gmail.com', 'pseudo' => 'thomkraft', 'roles' => [], 'password' => 'admin', 'is_admin' => 1],
            ['email' => 'alecpetitsiejak@gmail.com', 'pseudo' => 'AlecPts', 'roles' => [], 'password' => 'alecalec', 'is_admin' => 1],
        ];

        foreach ($usersData as $index=>$data) {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setPseudo($data['pseudo']);
            $user->setRoles($data['roles']);
            $user->setIsAdmin($data['is_admin']);

            // Hash password
            $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
            $user->setPassword($hashedPassword);
            $manager->persist($user);

            // Add reference for each user
            $this->addReference('user_' . ($index + 1), $user);
        }

        $manager->flush();
    }
}