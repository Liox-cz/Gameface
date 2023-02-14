<?php
declare(strict_types=1);

namespace Liox\Shop\Query;

use Doctrine\ORM\EntityManagerInterface;
use Liox\Shop\Entity\ProductVariant;
use Liox\Shop\Services\Cart\CartStorage;
use Liox\Shop\Value\CartItem;

readonly final class GetVariantsInCart
{
    public function __construct(
        private CartStorage $cartStorage,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @return list<ProductVariant>
     */
    public function __invoke(): array
    {
        $items = $this->cartStorage->getItems();

        $variantIds = array_map(
            static fn (CartItem $cartItem): string => $cartItem->productVariantId->toString(),
            $items,
        );

        return $this->entityManager->createQueryBuilder()
            ->select('product_variant')
            ->from(ProductVariant::class, 'product_variant')
            ->join('product_variant.product', 'product')
            ->where('product_variant.id IN (:variantIds)')
            ->setParameter('variantIds', $variantIds)
            ->addSelect('product')
            ->getQuery()
            ->getResult();
    }
}
