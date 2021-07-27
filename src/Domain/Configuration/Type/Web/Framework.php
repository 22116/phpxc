<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration\Type\Web;

use LSBProject\PHPXC\Domain\Configuration\ChoiceNodeInterface;
use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Framework extends Enum implements ChoiceNodeInterface
{
    private const NONE = 'none';
    private const SYMFONY = 'symfony';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::NONE => 'None',
            self::SYMFONY => 'Symfony',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'Framework';
    }
}
