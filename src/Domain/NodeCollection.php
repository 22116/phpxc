<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JetBrains\PhpStorm\Pure;
use LSBProject\PHPXC\Domain\Configuration\ChoiceNodeInterface;
use LSBProject\PHPXC\Domain\Configuration\NodeInterface;
use MyCLabs\Enum\Enum;
use OutOfBoundsException;

/**
 * @implements IteratorAggregate<int, NodeInterface>
 */
final class NodeCollection implements IteratorAggregate, Countable, ArrayAccess
{
    public const NAMESPACE_ALIAS = Configuration::class . '\\';

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
     * @template T of NodeInterface
     *
     * @param class-string<T> $type
     *
     * @return T|null
     */
    #[Pure]
    public function find(string $type, ?string $key = null): NodeInterface|null
    {
        /** @var T $node */
        foreach ($this->nodes as $node) {
            if (
                ($node instanceof $type || $node instanceof (self::NAMESPACE_ALIAS . $type)) &&
                (!($node instanceof Enum) || null === $key || $node->getKey() === $key)
            ) {
                    return $node;
            }
        }

        return null;
    }

    public function has(NodeInterface $target): bool
    {
        if ($target instanceof Enum) {
            foreach ($this->nodes as $node) {
                if ($target->equals($node)) {
                    return true;
                }
            }

            return false;
        }

        return (bool) $this->find($target::class);
    }

    public function add(NodeInterface $node): void
    {
        $this->nodes[] = $node;
    }

    #[Pure]
    public function merge(self $collection): self
    {
        return new self([...$this->nodes, ...$collection]);
    }
}
