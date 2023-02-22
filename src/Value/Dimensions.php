<?php
declare(strict_types=1);

namespace Liox\Shop\Value;

readonly final class Dimensions
{
    public function __construct(
        public int $width,
        public int $height,
    ) {
    }

    public function isSame(Dimensions $other): bool
    {
        return $this->width === $other->width
            && $this->height === $other->height;
    }
}
