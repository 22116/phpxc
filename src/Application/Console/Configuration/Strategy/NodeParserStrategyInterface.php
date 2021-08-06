<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Configuration\Strategy;

use Exception;
use Generator;
use LSBProject\PHPXC\Domain\Configuration\NodeInterface;

interface NodeParserStrategyInterface
{
    /**
     * @param array<string, mixed> $node
     *
     * @return Generator<NodeInterface>
     *
     * @throws Exception
     */
    public function read(array $node): Generator;
    public function supports(string $type): bool;
}
