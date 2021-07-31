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
     * @param array<string, string> $extra
     */
    public function __construct(
        protected string $description = '',
        protected array $preScripts = [],
        protected array $postScripts = [],
        protected string $parentName = '',
        protected array $extra = [],
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

    /**
     * {@inheritdoc}
     */
    public function getExtra(): array
    {
        return $this->extra;
    }
}
