<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration\Type\Cli;

use LSBProject\PHPXC\Domain\Configuration\ChoiceNodeInterface;
use LSBProject\PHPXC\Domain\Configuration\DeepNodeInterface;
use LSBProject\PHPXC\Domain\Configuration\Type\Cli\Type\Async;
use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Type extends Enum implements ChoiceNodeInterface, DeepNodeInterface
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

    public static function getTitle(): string
    {
        return 'Asynchronous/Synchronous';
    }
}
