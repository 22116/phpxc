<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration;

use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Testing extends Enum implements MultiChoiceNodeInterface
{
    private const PHPUNIT = 'phpunit';
    private const BEHAT = 'behat';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::PHPUNIT => 'PHPUnit',
            self::BEHAT => 'Behat',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'Testing tool';
    }
}