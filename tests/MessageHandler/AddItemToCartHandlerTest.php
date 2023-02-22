<?php
declare(strict_types=1);

namespace Liox\Shop\Tests\MessageHandler;

use Liox\Shop\Message\AddItemToCart;
use Liox\Shop\MessageHandler\AddItemToCartHandler;
use Liox\Shop\Services\Cart\CartStorage;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AddItemToCartHandlerTest extends KernelTestCase
{
    private CartStorage $cartStorage;
    private AddItemToCartHandler $handler;

    protected function setUp(): void
    {
        $this->handler = self::getContainer()->get(AddItemToCartHandler::class);
        $this->cartStorage = self::getContainer()->get(CartStorage::class);
    }


    public function test(): void
    {
        $variantId1 = Uuid::uuid7();
        $variantId2 = Uuid::uuid7();

        $items = $this->cartStorage->getItems();

        self::assertCount(0, $items);

        $this->handler->__invoke(new AddItemToCart($variantId1));

        $items = $this->cartStorage->getItems();

        self::assertCount(1, $items);

        self::assertTrue($variantId1->equals($items[0]->productVariantId));

        $this->handler->__invoke(new AddItemToCart($variantId1));
        $this->handler->__invoke(new AddItemToCart($variantId2));

        $items = $this->cartStorage->getItems();

        self::assertCount(3, $items);

        self::assertTrue($variantId1->equals($items[1]->productVariantId));
        self::assertTrue($variantId2->equals($items[2]->productVariantId));
    }
}
