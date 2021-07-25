<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration\Type\Cli;

use LSBProject\PHPXC\Configuration\ChoiceNodeInterface;
use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Framework extends Enum implements ChoiceNodeInterface
{
    private const NONE = 'none';
    private const WEBMOZART = 'webmozart';
    private const SYMFONY = 'symfony';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::NONE => 'None',
            self::WEBMOZART => 'webmozart/console',
            self::SYMFONY => 'symfony/console',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'CLI Framework';
    }
}
