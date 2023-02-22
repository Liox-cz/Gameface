<?php
declare(strict_types=1);

namespace Liox\Shop\Value;

use Liox\Shop\Entity\ProductVariant;

readonly final class ProductVariantInCart
{
    public function __construct(
        public ProductVariant $variant,
        public null|Dimensions $dimensions,
    ) {
    }
}
