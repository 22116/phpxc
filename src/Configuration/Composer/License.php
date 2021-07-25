<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration\Composer;

use LSBProject\PHPXC\Configuration\ChoiceNodeInterface;
use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class License extends Enum implements ChoiceNodeInterface
{
    private const AFL = 'afl-3.0';
    private const MIT = 'mit';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::AFL => 'afl-3.0',
            self::MIT => 'MIT',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'License';
    }
}
