<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration;

use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

class Containerization extends Enum implements ChoiceNodeInterface
{
    protected const NONE = 'none';
    protected const DOCKER = 'docker';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::NONE => 'None',
            self::DOCKER => 'Docker',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'Containerization tool';
    }
}