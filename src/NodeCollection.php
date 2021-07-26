<?php

declare(strict_types=1);

namespace LSBProject\PHPXC;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use LSBProject\PHPXC\Configuration\ChoiceNodeInterface;
use LSBProject\PHPXC\Configuration\NodeInterface;
use OutOfBoundsException;

/**
 * @implements IteratorAggregate<int, NodeInterface>
 */
final class NodeCollection implements IteratorAggregate, Countable, ArrayAccess
{
    /**
     * @var array<NodeInterface>
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
     * @param ChoiceNodeInterface $value
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

    /**
     * @param class-string<NodeInterface> $nodeType
     */
    public function findByNode(string $nodeType): NodeInterface|null
    {
        foreach ($this->nodes as $node) {
            if ($node instanceof $nodeType) {
                return $node;
            }
        }

        return null;
    }

    public function add(NodeInterface $node): void
    {
        $this->nodes[] = $node;
    }

    public function merge(self $collection): self
    {
        return new self([...$this->nodes, ...$collection]);
    }
}
