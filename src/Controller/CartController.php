<?php
declare(strict_types=1);

namespace Liox\Shop\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CartController extends AbstractController
{
    #[Route(path: '/cart', name: 'cart', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('cart.html.twig');
    }
}
