<?php
declare(strict_types=1);

namespace Liox\Shop\Message;

readonly final class SubscribeNewsletter
{
    public function __construct(
        public string $email,
    ) {
    }
}
