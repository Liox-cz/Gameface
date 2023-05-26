<?php
declare(strict_types=1);

namespace Liox\Shop\Controller;

use Liox\Shop\FormData\AddToCartFormData;
use Liox\Shop\FormType\AddToCartFormType;
use Liox\Shop\Message\AddItemToCart;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomepageController extends AbstractController
{
    #[Route(path: '/', name: 'homepage', methods: ['GET'])]
    public function __invoke(): Response
    {
        $addToCartForm = $this->createForm(AddToCartFormType::class, options: [
            'variants' => $variants,
        ]);

        $addToCartForm->handleRequest($request);

        if ($addToCartForm->isSubmitted() && $addToCartForm->isValid()) {
            $addToCartFormData = $addToCartForm->getData();
            assert($addToCartFormData instanceof AddToCartFormData);

            $this->messageBus->dispatch(
                new AddItemToCart(
                    Uuid::fromString($addToCartFormData->variantId),
                )
            );

            return $this->redirectToRoute('product_detail', ['productId' => $productId]);
        }

        return $this->render('homepage.html.twig');
    }
}
