<?php

declare(strict_types=1);

use Liox\Shop\Services\Cart\CartStorage;
use Liox\Shop\Services\Cart\InMemoryCartStorage;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function(ContainerConfigurator $configurator): void
{
    $services = $configurator->services();

    $services->defaults()
        ->autoconfigure()
        ->autowire()
        ->public();

    $services->alias(CartStorage::class, InMemoryCartStorage::class);
};
