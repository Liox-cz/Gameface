<?php
declare(strict_types=1);

namespace Liox\Shop\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Liox\Shop\Entity\ProductVariant;

final class ProductVariantRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    /**
     * @return array<ProductVariant>
     */
    public function findAll(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('product_variant')
            ->from(ProductVariant::class, 'product_variant')
            ->join('product_variant.product', 'product')
            ->addSelect('product')
            ->getQuery()
            ->getResult();
    }
}
