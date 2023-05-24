<?php

declare(strict_types=1);

use Liox\Shop\Services\Cart\CartStorage;
use Liox\Shop\Services\Cart\InMemoryCartStorage;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function(ContainerConfigurator $configurator): void
{
    $services = $configurator->services();

    // Data fixtures
    $services->load('Liox\\Shop\\Tests\\DataFixtures\\', __DIR__ . '/../tests/DataFixtures/{*.php}');

    $services->defaults()
        ->autoconfigure()
        ->autowire()
        ->public();

    $services->alias(CartStorage::class, InMemoryCartStorage::class);
};
