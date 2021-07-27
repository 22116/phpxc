<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration;

use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class StaticAnalyzer extends Enum implements MultiChoiceNodeInterface
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

    public static function getTitle(): string
    {
        return 'Static Analyzer tool';
    }
}