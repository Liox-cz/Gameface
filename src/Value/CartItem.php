<?php
declare(strict_types=1);

namespace Liox\Shop\Value;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

readonly final class CartItem
{
    public function __construct(
        public UuidInterface $productVariantId,
        public null|Dimensions $dimensions,
    ) {
    }


    /**
     * @return array{variant_id: string, dimensions: null|array{width: int, height: int}}
     */
    public function toArray(): array
    {
        return [
            'variant_id' => $this->productVariantId->toString(),
            'dimensions' => $this->dimensions ? [
                'width' => $this->dimensions->width,
                'height' => $this->dimensions->height,
            ] : null,
        ];
    }


    /**
     * @param array{variant_id: string, dimensions: null|array{width: int, height: int}} $data
     */
    public static function fromArray(array $data): self
    {
        $dimensions = $data['dimensions'] !== null
            ? new Dimensions($data['dimensions']['width'], $data['dimensions']['height'])
            : null;

        return new CartItem(Uuid::fromString($data['variant_id']), $dimensions);
    }


    public function isSame(CartItem $other): bool
    {
        return $this->toArray() === $other->toArray();
    }
}
