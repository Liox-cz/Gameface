<?php
declare(strict_types=1);

namespace Liox\Shop\Tests\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Liox\Shop\Entity\Product;
use Liox\Shop\Entity\ProductVariant;
use Liox\Shop\Value\Currency;
use Liox\Shop\Value\Price;
use Ramsey\Uuid\Uuid;

final class TestDataFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // TODO: Implement load() method.

        $product = new Product(
            Uuid::uuid7(),
            'Testovací kresbička',
        );

        $manager->persist($product);

        for ($i=1; $i<=2; $i++) {
            $variant = new ProductVariant(
                Uuid::uuid7(),
                $product,
                "Varianta $i",
                new Price(10, 21, Currency::CZK),
            );

            $manager->persist($variant);
        }

        $manager->flush();
    }
}
