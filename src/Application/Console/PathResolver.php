<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console;

use JetBrains\PhpStorm\Pure;

final class PathResolver
{
    #[Pure]
    public function resolve(string $path): string
    {
        return realpath($path) ?: '';
    }

    public function resolveTemplate(string $path): TemplatePath
    {
        return new TemplatePath($this->resolve($path) ?: '');
    }
}
