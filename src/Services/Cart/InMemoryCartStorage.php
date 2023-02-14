<?php
declare(strict_types=1);

namespace Liox\Shop\Services\Cart;

use Liox\Shop\Value\CartItem;
use Ramsey\Uuid\UuidInterface;
use SplObjectStorage;

final class InMemoryCartStorage implements CartStorage
{
    /** @var SplObjectStorage<UuidInterface, int> */
    private SplObjectStorage $items;

    public function __construct()
    {
        $this->items = new SplObjectStorage();
    }


    public function addItem(UuidInterface $productVariantId): void
    {
        $existing = $this->items[$productVariantId] ?? 0;
        $this->items[$productVariantId] = $existing + 1;
    }

    /**
     * @return list<CartItem>
     */
    public function getItems(): array
    {
        $cart = [];

        foreach ($this->items as $productVariantId) {
            $cart[] = new CartItem($productVariantId, $this->items[$productVariantId]);
        }

        return $cart;
    }

    public function clear(): void
    {
        $this->items = new SplObjectStorage();
    }
}
