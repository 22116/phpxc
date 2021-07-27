<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use LSBProject\PHPXC\Application\Console\Command;
use LSBProject\PHPXC\Domain\Contract\FilesystemInterface;
use LSBProject\PHPXC\Domain\Contract\ShellExecutorInterface;
use LSBProject\PHPXC\Domain\ScriptExecutor;
use LSBProject\PHPXC\Domain\TemplateBuilder;
use LSBProject\PHPXC\Infrastructure\Filesystem;
use LSBProject\PHPXC\Infrastructure\ShellExecutor;
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
        ->set(FilesystemInterface::class, Filesystem::class)
        ->set(ShellExecutorInterface::class, ShellExecutor::class)

        ->set(ScriptExecutor::class, ScriptExecutor::class)
            ->args([service(ShellExecutorInterface::class)])

        ->set(TemplateBuilder::class, TemplateBuilder::class)
            ->args([service(Environment::class), service(FilesystemInterface::class)])

        ->set(Command\Create::class, Command\Create::class)
            ->args([service(TemplateBuilder::class), service(ScriptExecutor::class)])

        ->set(FilesystemLoader::class, FilesystemLoader::class)
            ->args([__DIR__ . '/../templates'])

        ->set(Environment::class, Environment::class)
            ->args([service(FilesystemLoader::class), [
                'debug' => true
            ]])
    ;
};
