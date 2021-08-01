<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use JetBrains\PhpStorm\Pure;
use LSBProject\PHPXC\Domain\Configuration\NodeInterface;

/**
 * @implements IteratorAggregate<int, NodeInterface>
 */
final class NodeCollection implements IteratorAggregate, Countable
{
    /**
     * @var array<string|int, NodeInterface>
     */
    private array $nodes;

    /**
     * @param array<NodeInterface> $nodes
     */
    public function __construct(array $nodes = [])
    {
        $this->nodes = $nodes;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->nodes);
    }

    public function count(): int
    {
        return count($this->nodes);
    }

    public function set(string $key, NodeInterface $node): void
    {
        $this->nodes[$key] = $node;
    }

    public function has(string $key): bool
    {
        return isset($this->nodes[$key]);
    }

    #[Pure]
    public function merge(self $collection): self
    {
        return new self(array_merge($this->nodes, $collection->nodes));
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        return $this->nodes;
    }
}
