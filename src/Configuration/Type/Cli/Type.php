<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration\Type\Cli;

use LSBProject\PHPXC\Configuration\DeepNodeInterface;
use LSBProject\PHPXC\Configuration\Type\Cli\Type\Async;
use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Type extends Enum implements DeepNodeInterface
{
    private const SYNC = 'sync';
    private const ASYNC = 'async';

    /**
     * {@inheritdoc}
     */
    public function getChildren(): array
    {
        return match ($this->value) {
            self::ASYNC => [Async::class],
            self::SYNC => [],
            default => throw new InvalidNodeException()
        };
    }

    public function getDescription(): string
    {
        return match ($this->value) {
            self::ASYNC => 'Asynchronous',
            self::SYNC => 'Synchronous',
            default => throw new InvalidNodeException()
        };
    }
}
