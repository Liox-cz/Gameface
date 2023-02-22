<?php
declare(strict_types=1);

namespace Liox\Shop\Services\Cart;

use Liox\Shop\Value\CartItem;

interface CartStorage
{
    public function addItem(CartItem $item): void;

    /**
     * @return list<CartItem>
     */
    public function getItems(): array;

    public function removeItem(CartItem $itemToRemove): void;

    public function clear(): void;
}
