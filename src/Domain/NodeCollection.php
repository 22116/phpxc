<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JetBrains\PhpStorm\Pure;
use LSBProject\PHPXC\Domain\Configuration\NodeInterface;
use OutOfBoundsException;

/**
 * @implements IteratorAggregate<int, NodeInterface>
 */
final class NodeCollection implements IteratorAggregate, Countable, ArrayAccess
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

    /**
     * {@inheritdoc}
     *
     * @param int $offset
     */
    public function offsetExists($offset): bool
    {
        return isset($this->nodes[$offset]);
    }

    /**
     * {@inheritdoc}
     *
     * @param int $offset
     */
    public function offsetGet($offset): NodeInterface
    {
        return $this->offsetExists($offset) ? $this->nodes[$offset] : throw new OutOfBoundsException();
    }

    /**
     * {@inheritdoc}
     *
     * @param int $offset
     * @param NodeInterface $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->nodes[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     *
     * @param int $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->nodes[$offset]);
    }

    public function set(string $key, NodeInterface $node): void
    {
        $this->nodes[$key] = $node;
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
