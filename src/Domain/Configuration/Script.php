<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
final class Script
{
    /**
     * @param string[] $includes
     * @param string[] $excludes
     */
    public function __construct(private string $command, private array $includes = [], private array $excludes = [])
    {
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return string[]
     */
    public function getIncludes(): array
    {
        return $this->includes;
    }

    /**
     * @return string[]
     */
    public function getExcludes(): array
    {
        return $this->excludes;
    }
}
