<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration;

use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class StaticAnalyzer extends Enum implements MultiNodeInterface
{
    private const PHPSTAN = 'phpstan';
    private const PSALM = 'psalm';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::PHPSTAN => 'PHPStan',
            self::PSALM => 'Psalm',
            default => throw new InvalidNodeException()
        };
    }
}
