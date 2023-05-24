<?php
declare(strict_types=1);

namespace Liox\Shop\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductsControllerTest extends WebTestCase
{
    public function testPageCanBeRenderedWithoutLogin(): void
    {
        $client = self::createClient();

        $client->request('GET', '/products');

        self::assertResponseIsSuccessful();
    }
}
