<?php
declare(strict_types=1);

namespace Liox\Shop\Services\Cart;

use Liox\Shop\Value\CartItem;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class SessionCartStorage implements CartStorage
{
    private const SESSION_NAME = 'cart_items';

    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
    }

    public function addItem(UuidInterface $productVariantId): void
    {
        $session = $this->requestStack->getSession();

        /** @var array<string, int> $items */
        $items = $session->get(self::SESSION_NAME, []);

        $existingValue = $items[$productVariantId->toString()] ?? 0;
        $items[$productVariantId->toString()] = $existingValue + 1;

        $session->set(self::SESSION_NAME, $items);
    }

    /**
     * @return list<CartItem>
     */
    public function getItems(): array
    {
        $session = $this->requestStack->getSession();

        /** @var array<string, int> $items */
        $items = $session->get(self::SESSION_NAME, []);

        $cart = [];

        foreach ($items as $productVariantIdAsString => $amount) {
            $cart[] = new CartItem(Uuid::fromString($productVariantIdAsString), $amount);
        }

        return $cart;
    }
}
