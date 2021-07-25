<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Console\ConfigurationReader\Strategy;

use Generator;
use LSBProject\PHPXC\Configuration\NodeInterface;

interface NodeParserStrategyInterface
{
    /**
     * @param class-string<NodeInterface> $node
     *
     * @return Generator<NodeInterface>
     */
    public function read(string $node): Generator;

    /**
     * @param class-string<NodeInterface> $node
     */
    public function supports(string $node): bool;
}
