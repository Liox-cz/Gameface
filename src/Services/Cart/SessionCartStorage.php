<?php
declare(strict_types=1);

namespace Liox\Shop\Services\Cart;

use Liox\Shop\Value\CartItem;
use Symfony\Component\HttpFoundation\RequestStack;

final class SessionCartStorage implements CartStorage
{
    private const SESSION_NAME = 'cart_items';

    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
    }

    public function addItem(CartItem $item): void
    {
        $session = $this->requestStack->getSession();

        /** @var array<mixed> $items */
        $items = $session->get(self::SESSION_NAME, []);

        $items[] = $item->toArray();

        $session->set(self::SESSION_NAME, $items);
    }

    /**
     * @return list<CartItem>
     */
    public function getItems(): array
    {
        $session = $this->requestStack->getSession();

        /** @var list<array{variant_id: string, dimensions: null|array{width: int, height: int}}> $items */
        $items = $session->get(self::SESSION_NAME, []);

        $cart = [];

        foreach ($items as $itemData) {
            $cart[] = CartItem::fromArray($itemData);
        }

        return $cart;
    }

    public function countItems(): int
    {
        $session = $this->requestStack->getSession();

        /** @var array<mixed> $items */
        $items = $session->get(self::SESSION_NAME, []);

        return count($items);
    }

    public function clear(): void
    {
        $this->requestStack->getSession()
            ->clear();
    }

    public function removeItem(CartItem $itemToRemove): void
    {
        $session = $this->requestStack->getSession();

        /** @var list<array{variant_id: string, dimensions: null|array{width: int, height: int}}> $items */
        $items = $session->get(self::SESSION_NAME, []);

        foreach ($items as $key => $itemData) {
            $itemInCart = CartItem::fromArray($itemData);

            if ($itemInCart->isSame($itemToRemove)) {
                unset($items[$key]);
                $session->set(self::SESSION_NAME, $items);

                return;
            }
        }
    }
}
