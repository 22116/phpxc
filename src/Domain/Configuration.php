<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain;

use JetBrains\PhpStorm\Immutable;
use LSBProject\PHPXC\Domain\Configuration\NodeCollection;

#[Immutable]
final class Configuration
{
    /**
     * @param string[] $directoryIgnoreList
     */
    public function __construct(
        private NodeCollection $nodes,
        private bool $removeEmptyDirectories,
        private array $directoryIgnoreList,
    ) {
    }

    public function getNodes(): NodeCollection
    {
        return $this->nodes;
    }

    public function isRemoveEmptyDirectories(): bool
    {
        return $this->removeEmptyDirectories;
    }

    /**
     * @return string[]
     */
    public function getDirectoryIgnoreList(): array
    {
        return $this->directoryIgnoreList;
    }
}
