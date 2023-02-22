<?php
declare(strict_types=1);

namespace Liox\Shop\MessageHandler;

use Liox\Shop\Message\RemoveItemFromCart;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class RemoveItemFromCartHandler
{
    public function __invoke(RemoveItemFromCart $message): void
    {

    }
}
