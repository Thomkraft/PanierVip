<?php

namespace App\Tests\Controller;

use App\Entity\Quantity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class QuantityControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $quantityRepository;
    private string $path = '/quantity/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->quantityRepository = $this->manager->getRepository(Quantity::class);

        foreach ($this->quantityRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Quantity index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'quantity[quantity]' => 'Testing',
            'quantity[bought]' => 'Testing',
            'quantity[idProduct]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->quantityRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Quantity();
        $fixture->setQuantity('My Title');
        $fixture->setBought('My Title');
        $fixture->setIdProduct('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Quantity');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Quantity();
        $fixture->setQuantity('Value');
        $fixture->setBought('Value');
        $fixture->setIdProduct('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'quantity[quantity]' => 'Something New',
            'quantity[bought]' => 'Something New',
            'quantity[idProduct]' => 'Something New',
        ]);

        self::assertResponseRedirects('/quantity/');

        $fixture = $this->quantityRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getQuantity());
        self::assertSame('Something New', $fixture[0]->getBought());
        self::assertSame('Something New', $fixture[0]->getIdProduct());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Quantity();
        $fixture->setQuantity('Value');
        $fixture->setBought('Value');
        $fixture->setIdProduct('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/quantity/');
        self::assertSame(0, $this->quantityRepository->count([]));
    }
}
