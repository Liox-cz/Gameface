<?php
declare(strict_types=1);

namespace Liox\Shop\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Liox\Shop\Doctrine\CartItemsDoctrineType;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
final class Cart
{
    #[ORM\Column(type: CartItemsDoctrineType::NAME)]
    private array $items = [];

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $lastInteraction;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: UuidType::NAME, unique: true)]
        private readonly UuidInterface $id,
    ) {
    }

    public function addItem(ProductVariant $productVariant): void
    {
    }

    public function changeItemAmount(): void
    {
    }

    public function removeItem(): void
    {
    }

    public function clear(): void
    {
        $this->items = [];
    }
}
