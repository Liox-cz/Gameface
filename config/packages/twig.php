<?php

declare(strict_types=1);

use Liox\Shop\Twig\CartTemplate;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (\Symfony\Config\TwigConfig $twig): void {
    $twig->formThemes(['bootstrap_5_layout.html.twig']);

    $twig->global('cart')->value(
        service(CartTemplate::class)
    );
    $twig->global('cart_total_price')->value(0);

    $twig->date([
        'timezone' => 'Europe/Prague',
    ]);

};
