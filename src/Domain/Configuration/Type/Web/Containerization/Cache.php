<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration\Type\Web\Containerization;

use LSBProject\PHPXC\Domain\Configuration\MultiChoiceNodeInterface;
use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Cache extends Enum implements MultiChoiceNodeInterface
{
    private const MEMCACHED = 'memcached';
    private const REDIS = 'redis';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::MEMCACHED => 'Memcached',
            self::REDIS => 'Redis',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'Caching tools';
    }
}
