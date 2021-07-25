<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration\Type\Web;

use LSBProject\PHPXC\Configuration\NodeInterface;
use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Framework extends Enum implements NodeInterface
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
}
