<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration;

use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Containerization extends Enum implements NodeInterface
{
    private const NONE = 'none';
    private const DOCKER = 'docker';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::NONE => 'None',
            self::DOCKER => 'Docker',
            default => throw new InvalidNodeException()
        };
    }
}
