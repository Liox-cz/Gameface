<?php
declare(strict_types=1);

namespace Liox\Shop\Services\Cart;

use Liox\Shop\Value\CartItem;
use Ramsey\Uuid\UuidInterface;

interface CartStorage
{
    public function addItem(UuidInterface $productVariantId): void;

    /**
     * @return list<CartItem>
     */
    public function getItems(): array;

    public function clear(): void;
}
