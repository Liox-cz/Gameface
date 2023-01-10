<?php
declare(strict_types=1);

namespace Liox\Shop\Ui\Homepage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomepageController extends AbstractController
{
    #[Route(path: '/', name: 'homepage', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('Homepage/homepage.html.twig');
    }
}
