<?php

declare(strict_types=1);

use Liox\Shop\Services\Cart\Cart;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (\Symfony\Config\TwigConfig $twig): void {
    $twig->formThemes(['bootstrap_5_layout.html.twig']);

    $twig->global('cart')->value(
        service(Cart::class)
    );

    $twig->date([
        'timezone' => 'Europe/Prague',
    ]);

};
