<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class TemplatePath
{
    public function __construct(private string $path)
    {
    }

    public function getTemplate(): string
    {
        return $this->path . '/template';
    }

    public function getConfiguration(): string
    {
        return $this->path . '/config.yaml';
    }
}
