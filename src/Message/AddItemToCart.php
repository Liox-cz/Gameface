<?php
declare(strict_types=1);

namespace Liox\Shop\Message;

use Ramsey\Uuid\UuidInterface;

readonly final class AddItemToCart
{
    public function __construct(
        public UuidInterface $productVariantId,
    ) {}
}
