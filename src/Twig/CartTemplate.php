<?php
declare(strict_types=1);

namespace Liox\Shop\Twig;

use Liox\Shop\Query\GetVariantsInCart;
use Liox\Shop\Services\Cart\CartStorage;
use Liox\Shop\Value\Currency;
use Liox\Shop\Value\Price;

readonly final class CartTemplate
{
    public function __construct(
        private GetVariantsInCart $getVariantsInCart,
        private CartStorage $cartStorage,
    ) {
    }

    public function itemsCount(): int
    {
        $total = 0;

        foreach ($this->cartStorage->getItems() as $item) {
            $total += $item->amount;
        }

        return $total;
    }

    public function totalPrice(): Price
    {
        $variantsInCart = $this->getVariantsInCart->__invoke();
        $totalWithoutVat = 0;

        foreach ($variantsInCart as $variantInCart) {
            foreach ($this->cartStorage->getItems() as $item) {
                if ($item->productVariantId->equals($variantInCart->id)) {
                    $totalWithoutVat += ($item->amount * $variantInCart->price->valueWithoutVat);
                }
            }
        }

        return new Price($totalWithoutVat, 21, Currency::CZK);
    }
}
