<?php
declare(strict_types=1);

namespace Liox\Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use Liox\Shop\Doctrine\AddressDoctrineType;
use Liox\Shop\Value\Address;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Order
{
    /**
     * @param array<OrderItem> $items
     */
    private function __construct(
        #[ORM\Id]
        #[ORM\Column(type: UuidType::NAME, unique: true)]
        public readonly UuidInterface $id,

        #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class)]
        public readonly array $items,

        #[ORM\Column(type: AddressDoctrineType::NAME)]
        public readonly Address $shippingAddress,

        #[ORM\Column(type: AddressDoctrineType::NAME, nullable: true)]
        public readonly null|Address $invoicingAddress,
    ) {
    }
}
