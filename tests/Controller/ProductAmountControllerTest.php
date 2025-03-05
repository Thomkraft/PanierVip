<?php

namespace App\Tests\Controller;

use App\Entity\ProductAmount;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ProductAmountControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $productAmountRepository;
    private string $path = '/product/amount/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->productAmountRepository = $this->manager->getRepository(ProductAmount::class);

        foreach ($this->productAmountRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ProductAmount index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'product_amount[amount]' => 'Testing',
            'product_amount[idUser]' => 'Testing',
            'product_amount[idProduct]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->productAmountRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ProductAmount();
        $fixture->setAmount('My Title');
        $fixture->setIdUser('My Title');
        $fixture->setIdProduct('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ProductAmount');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ProductAmount();
        $fixture->setAmount('Value');
        $fixture->setIdUser('Value');
        $fixture->setIdProduct('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'product_amount[amount]' => 'Something New',
            'product_amount[idUser]' => 'Something New',
            'product_amount[idProduct]' => 'Something New',
        ]);

        self::assertResponseRedirects('/product/amount/');

        $fixture = $this->productAmountRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getAmount());
        self::assertSame('Something New', $fixture[0]->getIdUser());
        self::assertSame('Something New', $fixture[0]->getIdProduct());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new ProductAmount();
        $fixture->setAmount('Value');
        $fixture->setIdUser('Value');
        $fixture->setIdProduct('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/product/amount/');
        self::assertSame(0, $this->productAmountRepository->count([]));
    }
}
