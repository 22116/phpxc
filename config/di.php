<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use LSBProject\PHPXC\Console\Command;
use LSBProject\PHPXC\TemplateBuilder;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return static function(ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services
        ->set(TemplateBuilder::class, TemplateBuilder::class)

        ->set(Command\Create::class, Command\Create::class)
            ->args([service(TemplateBuilder::class)])

        ->set(FilesystemLoader::class, FilesystemLoader::class)
            ->args([__DIR__ . '/../templates'])

        ->set(Environment::class, Environment::class)
            ->args([service(FilesystemLoader::class), [
                'cache' => __DIR__ . '/../twig_cache',
            ]])
    ;
};
