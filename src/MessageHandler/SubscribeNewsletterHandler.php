<?php
declare(strict_types=1);

namespace Liox\Shop\MessageHandler;

use Liox\Shop\Entity\NewsletterSubscription;
use Liox\Shop\Exceptions\EmailAlreadySubscribedToNewsletter;
use Liox\Shop\Message\SubscribeNewsletter;
use Liox\Shop\Repository\NewsletterSubscriptionRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly final class SubscribeNewsletterHandler
{
    public function __construct(
        private NewsletterSubscriptionRepository $newsletterSubscriptionRepository,
    ) {
    }

    /**
     * @throws EmailAlreadySubscribedToNewsletter
     */
    public function __invoke(SubscribeNewsletter $command): void
    {
        if ($this->newsletterSubscriptionRepository->isAlreadySubscribed($command->email)) {
            throw new EmailAlreadySubscribedToNewsletter();
        }

        $subscription = new NewsletterSubscription(
            Uuid::uuid7(),
            $command->email,
            new \DateTimeImmutable(),
        );

        $this->newsletterSubscriptionRepository->save($subscription);
    }
}
