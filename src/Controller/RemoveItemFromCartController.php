<?php
declare(strict_types=1);

namespace Liox\Shop\Controller;

use Liox\Shop\Services\Cart\CartStorage;
use Liox\Shop\Value\CartItem;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RemoveItemFromCartController extends AbstractController
{
    public function __construct(
        private readonly CartStorage $cartStorage,
    ) {
    }

    #[Route(path: '/remove-item-from-cart/{variantId}', name: 'remove_item_from_cart', methods: ['GET'])]
    public function __invoke(string $variantId): Response
    {
        try {
            $this->cartStorage->removeItem(
                new CartItem(Uuid::fromString($variantId), null),
            );
        } finally {
            return $this->redirectToRoute('cart');
        }
    }
}
