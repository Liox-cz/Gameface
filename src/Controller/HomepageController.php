<?php
declare(strict_types=1);

namespace Liox\Shop\Controller;

use Liox\Shop\Exceptions\EmailAlreadySubscribedToNewsletter;
use Liox\Shop\FormData\AddToCartFormData;
use Liox\Shop\FormData\SubscribeNewsletterFormData;
use Liox\Shop\FormType\AddToCartFormType;
use Liox\Shop\FormType\SubscribeNewsletterFormType;
use Liox\Shop\Message\AddItemToCart;
use Liox\Shop\Message\SubscribeNewsletter;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class HomepageController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {
    }

    #[Route(path: '/', name: 'homepage', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $subscribeNewsletterForm = $this->createForm(SubscribeNewsletterFormType::class);
        $subscribeNewsletterForm->handleRequest($request);

        if ($subscribeNewsletterForm->isSubmitted() && $subscribeNewsletterForm->isValid()) {
            $formData = $subscribeNewsletterForm->getData();
            assert($formData instanceof SubscribeNewsletterFormData);

            try {
                $this->messageBus->dispatch(
                    new SubscribeNewsletter($formData->email)
                );

                $this->addFlash('bg-success text-white', 'Děkujeme za subscribe! Budeme tě informovat o nových kolekcích, akčních slevách, chystajících se collabech a podobně!');
            } catch (HandlerFailedException $handlerFailedException) {
                $previousException = $handlerFailedException->getPrevious();

                if ($previousException instanceof EmailAlreadySubscribedToNewsletter) {
                    $this->addFlash('bg-warning text-white', 'Tvůj e-mail je již subscribnut a o žádnou z našich novinek nepřijdeš!');
                }
            }


            return $this->redirectToRoute('homepage');
        }

        return $this->render('homepage.html.twig', [
            'subscribe_newsletter_form' => $subscribeNewsletterForm,
        ]);
    }
}
