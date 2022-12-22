<?php

declare(strict_types=1);

use LioxAI\Framework\LioxKernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new LioxKernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
