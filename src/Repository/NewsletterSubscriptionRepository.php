<?php
declare(strict_types=1);

namespace Liox\Shop\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Liox\Shop\Entity\NewsletterSubscription;
use Liox\Shop\Exceptions\ProductNotFound;

readonly final class NewsletterSubscriptionRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * @throws ProductNotFound
     */
    public function save(NewsletterSubscription $newsletterSubscription): void
    {
        $this->entityManager->persist($newsletterSubscription);
        $this->entityManager->flush();
    }

    public function isAlreadySubscribed(string $email): bool
    {
        $qb = $this->entityManager->createQueryBuilder();
        $count = $qb->select('COUNT(newsletter_subscription)')
            ->from(NewsletterSubscription::class, 'newsletter_subscription')
            ->where('newsletter_subscription.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getSingleScalarResult();

        return $count > 0;
    }
}
