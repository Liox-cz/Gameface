<?php
declare(strict_types=1);

namespace Liox\Shop\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Liox\Shop\Entity\Product;
use Liox\Shop\Exceptions\ProductNotFound;
use Ramsey\Uuid\UuidInterface;

readonly final class ProductRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * @throws ProductNotFound
     */
    public function get(UuidInterface $productId): Product
    {
        $product = $this->entityManager->find(Product::class, $productId);

        if ($product instanceof Product) {
            return $product;
        }

        throw new ProductNotFound();
    }

    /**
     * @return array<Product>
     */
    public function findAll(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('product')
            ->from(Product::class, 'product')
            ->getQuery()
            ->getResult();
    }
}
