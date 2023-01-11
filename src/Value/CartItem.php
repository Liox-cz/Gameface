<?php
declare(strict_types=1);

namespace Liox\Shop\Value;

use Ramsey\Uuid\UuidInterface;

readonly final class CartItem
{
    public function __construct(
        public UuidInterface $productVariantId,
        public int $amount,
    ) {
    }
}
