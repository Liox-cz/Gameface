<?php
declare(strict_types=1);

namespace Liox\Shop\Value;

readonly final class Price
{
    public function __construct(
        public int $valueWithoutVat,
        public int $vat,
        public Currency $currency,
    ) {
    }
}
