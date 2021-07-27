<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration\Type\Cli\Type;

use LSBProject\PHPXC\Domain\Configuration\ChoiceNodeInterface;
use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Async extends Enum implements ChoiceNodeInterface
{
    private const REACTPHP = 'reactphp';
    private const AMP = 'amp';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::REACTPHP => 'ReactPHP',
            self::AMP => 'AMP',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'Asynchronous Framework';
    }
}