<?php
declare(strict_types=1);

namespace Liox\Shop\Tests\Value;

use Generator;
use Liox\Shop\Value\Dimensions;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DimensionsTest extends TestCase
{
    #[DataProvider('provideValues')]
    public function testIsSame(
        int $widthA,
        int $heightA,
        int $widthB,
        int $heightB,
        bool $expected,
    ): void
    {
        $a = new Dimensions($widthA, $heightA);
        $b = new Dimensions($widthB, $heightB);

        $this->assertSame($expected, $a->isSame($b));
        $this->assertSame($expected, $b->isSame($a));
    }

    /**
     * @return Generator<array{int, int, int, int, bool}>
     */
    public static function provideValues(): Generator
    {
        yield [10, 20, 10, 20, true];
        yield [10, 20, 20, 10, false];
        yield [10, 10, 10, 20, false];
    }
}
