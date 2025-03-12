<?php

namespace App\Tests\Controller;

use App\Entity\ShoppingList;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ShoppingListControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $shoppingListRepository;
    private string $path = '/shopping/list/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->shoppingListRepository = $this->manager->getRepository(ShoppingList::class);

        foreach ($this->shoppingListRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ShoppingList index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'shopping_list[name]' => 'Testing',
            'shopping_list[nbProducts]' => 'Testing',
            'shopping_list[products]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->shoppingListRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ShoppingList();
        $fixture->setName('My Title');
        $fixture->setNbProducts('My Title');
        $fixture->setProducts('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ShoppingList');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ShoppingList();
        $fixture->setName('Value');
        $fixture->setNbProducts('Value');
        $fixture->setProducts('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'shopping_list[name]' => 'Something New',
            'shopping_list[nbProducts]' => 'Something New',
            'shopping_list[products]' => 'Something New',
        ]);

        self::assertResponseRedirects('/shopping/list/');

        $fixture = $this->shoppingListRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getNbProducts());
        self::assertSame('Something New', $fixture[0]->getProducts());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new ShoppingList();
        $fixture->setName('Value');
        $fixture->setNbProducts('Value');
        $fixture->setProducts('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/shopping/list/');
        self::assertSame(0, $this->shoppingListRepository->count([]));
    }
}
