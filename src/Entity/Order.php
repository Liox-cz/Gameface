<?php
declare(strict_types=1);

namespace Liox\Shop\Entity;

use Doctrine\ORM\Mapping as ORM;
use Liox\Shop\Doctrine\AddressDoctrineType;
use Liox\Shop\Doctrine\CustomerDoctrineType;
use Liox\Shop\Value\Address;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
final class Order
{
    /**
     * @param array<OrderItem> $items
     */
    private function __construct(
        #[ORM\Id]
        #[ORM\Column(type: UuidType::NAME, unique: true)]
        private readonly UuidInterface $id,

        #[ORM\ManyToOne(targetEntity: OrderItem::class)]
        private readonly array $items,

        #[ORM\Column(type: CustomerDoctrineType::NAME)]
        private readonly Customer $customer,

        #[ORM\Column(type: AddressDoctrineType::NAME)]
        private readonly Address $shippingAddress,

        #[ORM\Column(type: AddressDoctrineType::NAME, nullable: true)]
        private readonly null|Address $invoicingAddress,
    ) {
    }
}
