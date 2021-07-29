<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration;

use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Node implements NodeInterface
{
    /**
     * @param Script[] $preScripts
     * @param Script[] $postScripts
     */
    public function __construct(
        protected string $description = '',
        protected array $preScripts = [],
        protected array $postScripts = [],
        protected string $parentName = ''
    ) {
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreScripts(): array
    {
        return $this->preScripts;
    }

    /**
     * {@inheritdoc}
     */
    public function getPostScripts(): array
    {
        return $this->postScripts;
    }

    public function getParentName(): string
    {
        return $this->parentName;
    }
}
