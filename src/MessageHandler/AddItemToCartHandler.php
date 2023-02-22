<?php
declare(strict_types=1);

namespace Liox\Shop\MessageHandler;

use Liox\Shop\Message\AddItemToCart;
use Liox\Shop\Services\Cart\CartStorage;
use Liox\Shop\Value\CartItem;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly final class AddItemToCartHandler
{
    public function __construct(
        private CartStorage $cartStorage,
    ) {
    }

    public function __invoke(AddItemToCart $message): void
    {
        $item = new CartItem($message->productVariantId, null);

        $this->cartStorage->addItem($item);
    }
}
