<?php
declare(strict_types=1);

namespace Liox\Shop\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Liox\Shop\Doctrine\AddressDoctrineType;
use Liox\Shop\Value\Address;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Order
{
    /**
     * @param Collection<int, OrderItem> $items
     */
    private function __construct(
        #[ORM\Id]
        #[ORM\Column(type: UuidType::NAME, unique: true)]
        public readonly UuidInterface $id,

        #[ORM\Column(type: AddressDoctrineType::NAME)]
        public readonly Address $shippingAddress,

        #[ORM\Column(type: AddressDoctrineType::NAME, nullable: true)]
        public readonly null|Address $invoicingAddress,

        #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class)]
        public readonly Collection $items,
    ) {
    }
}
