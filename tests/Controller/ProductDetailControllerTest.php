<?php
declare(strict_types=1);

namespace Liox\Shop\Tests\Controller;

use Liox\Shop\Tests\DataFixtures\TestDataFixture;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductDetailControllerTest extends WebTestCase
{
    public function testSomethingCanBeAddedToTheCart(): void
    {
        $client = self::createClient();

        $url = sprintf('/product/%s', TestDataFixture::PRODUCT_ID);
        $crawler = $client->request('GET', $url);

        $form = $crawler->selectButton('Do košíku')->form();

        $client->submit($form, [
            $form->getName() . '[variantId]' => TestDataFixture::VARIANT_1_ID,
        ]);

        self::assertResponseRedirects($url);
    }
}
