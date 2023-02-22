<?php
declare(strict_types=1);

namespace Liox\Shop\Services\Cart;

use Liox\Shop\Query\GetVariants;
use Liox\Shop\Value\CartItem;
use Liox\Shop\Value\Currency;
use Liox\Shop\Value\ProductVariantInCart;
use Liox\Shop\Value\TotalPriceWithVat;
use Ramsey\Uuid\UuidInterface;

readonly final class Cart
{
    public function __construct(
        private GetVariants $getVariantsInCart,
        private CartStorage $cartStorage,
    ) {
    }

    public function itemsCount(): int
    {
        return count($this->cartStorage->getItems());
    }

    public function totalPrice(): TotalPriceWithVat
    {
        $variantIds = array_map(
            static fn (CartItem $cartItem): UuidInterface => $cartItem->productVariantId,
            $this->cartStorage->getItems(),
        );

        $variantsInCart = $this->getVariantsInCart->byIds($variantIds);
        $totalWithVat = new TotalPriceWithVat(0, Currency::CZK);

        foreach ($variantsInCart as $variantInCart) {
            foreach ($this->cartStorage->getItems() as $item) {
                if ($item->productVariantId->equals($variantInCart->id)) {
                    // TODO: calculate with dimensions * price per unit
                    $totalWithVat = $totalWithVat->add($variantInCart->price->valueWithoutVat);
                }
            }
        }

        return $totalWithVat;
    }

    /**
     * @return list<ProductVariantInCart>
     */
    public function items(): array
    {
        $variantIds = array_map(
            static fn (CartItem $cartItem): UuidInterface => $cartItem->productVariantId,
            $this->cartStorage->getItems(),
        );

        $variantsInCart = $this->getVariantsInCart->byIds($variantIds);
        $variantItemsInCart = [];

        foreach ($variantsInCart as $variantInCart) {
            foreach ($this->cartStorage->getItems() as $item) {
                if ($item->productVariantId->equals($variantInCart->id)) {
                    $variantItemsInCart[] = new ProductVariantInCart($variantInCart, $item->dimensions);
                }
            }
        }

        return $variantItemsInCart;
    }
}
