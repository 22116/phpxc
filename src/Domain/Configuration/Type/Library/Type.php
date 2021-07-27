<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration\Type\Library;

use LSBProject\PHPXC\Domain\Configuration\ChoiceNodeInterface;
use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Type extends Enum implements ChoiceNodeInterface
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
