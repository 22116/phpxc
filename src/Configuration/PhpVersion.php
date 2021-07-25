<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration;

use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class PhpVersion extends Enum implements NodeInterface
{
    private const V7 = '7';
    private const V71 = '7.1';
    private const V72 = '7.2';
    private const V73 = '7.3';
    private const V74 = '7.4';
    private const V8 = '8.0';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::V7 => '^v7.0',
            self::V71 => '^v7.1',
            self::V72 => '^v7.2',
            self::V73 => '^v7.3',
            self::V74 => '^v7.4',
            self::V8 => '^v8.0',
            default => throw new InvalidNodeException()
        };
    }
}
