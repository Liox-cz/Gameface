<?php
declare(strict_types=1);

namespace Liox\Shop\Tests\Value;

use Generator;
use Liox\Shop\Value\CartItem;
use Liox\Shop\Value\Dimensions;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CartItemTest extends TestCase
{
    #[DataProvider('provideValues')]
    public function testIsSame(
        UuidInterface $variantIdA,
        UuidInterface $variantIdB,
        null|Dimensions $dimensionsA,
        null|Dimensions $dimensionsB,
        bool $expected,
    ): void
    {
        $a = new CartItem($variantIdA, $dimensionsA);
        $b = new CartItem($variantIdB, $dimensionsB);

        $this->assertSame($expected, $a->isSame($b));
        $this->assertSame($expected, $b->isSame($a));
    }

    /**
     * @return Generator<array{UuidInterface, UuidInterface, null|Dimensions, null|Dimensions, bool}>
     */
    public static function provideValues(): Generator
    {
        $uuid1 = Uuid::uuid7();
        $uuid2 = Uuid::uuid7();
        $dimension1 =  new Dimensions(10, 20);
        $dimension2 =  new Dimensions(20, 10);

        yield [clone $uuid1, clone $uuid1, null, null, true];

        yield [
            clone $uuid1,
            clone $uuid1,
            clone $dimension1,
            clone $dimension1,
            true,
        ];

        yield [$uuid1, $uuid2, null, null, false];

        yield [$uuid1, $uuid2, $dimension1, null, false];

        yield [$uuid1, $uuid2, clone $dimension1, clone $dimension1, false];

        yield [clone $uuid1, clone $uuid1, $dimension1, $dimension2, false];

        yield [clone $uuid1, clone $uuid1, null, $dimension2, false];

        yield [clone $uuid1, clone $uuid1, $dimension1, null, false];
    }


    public function testToArrayWithoutDimensions(): void
    {
        $uuid = Uuid::uuid7();
        $item = new CartItem($uuid, null);

        $expected = [
            'variant_id' => $uuid->toString(),
            'dimensions' => null,
        ];

        $this->assertSame($expected, $item->toArray());
    }


    public function testToArrayWithDimensions(): void
    {
        $uuid = Uuid::uuid7();
        $dimensions = new Dimensions(10, 20);
        $item = new CartItem($uuid, $dimensions);

        $expected = [
            'variant_id' => $uuid->toString(),
            'dimensions' => [
                'width' => 10,
                'height' => 20,
            ],
        ];

        $this->assertSame($expected, $item->toArray());
    }


    public function testFromArrayWithoutDimensions(): void
    {
        $uuid = Uuid::uuid7();

        $data = [
            'variant_id' => $uuid->toString(),
            'dimensions' => null,
        ];

        $item = CartItem::fromArray($data);

        $this->assertTrue($uuid->equals($item->productVariantId));
        $this->assertNull($item->dimensions);
    }


    public function testFromArrayWithDimensions(): void
    {
        $uuid = Uuid::uuid7();
        $dimensions = new Dimensions(10, 20);

        $data = [
            'variant_id' => $uuid->toString(),
            'dimensions' => [
                'width' => $dimensions->width,
                'height' => $dimensions->height,
            ],
        ];

        $item = CartItem::fromArray($data);

        $this->assertTrue($uuid->equals($item->productVariantId));
        $this->assertTrue($dimensions->isSame($item->dimensions));
    }
}
