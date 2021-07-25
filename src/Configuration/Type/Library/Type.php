<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration\Type\Library;

use LSBProject\PHPXC\Configuration\NodeInterface;
use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Type extends Enum implements NodeInterface
{
    private const EMPTY = 'empty';
    private const SYMFONY_BUNDLE = 'symfony-bundle';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::EMPTY => 'Empty',
            self::SYMFONY_BUNDLE => 'Symfony Bundle',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'Library type';
    }
}
