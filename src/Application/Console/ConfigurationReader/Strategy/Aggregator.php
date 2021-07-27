<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\ConfigurationReader\Strategy;

use Generator;
use LSBProject\PHPXC\Domain\Configuration\DeepNodeInterface;
use ReflectionClass;

final class Aggregator implements NodeParserStrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function read(string $node): Generator
    {
        yield new $node();
    }

    public function supports(string $node): bool
    {
        return (new ReflectionClass($node))->implementsInterface(DeepNodeInterface::class);
    }
}
