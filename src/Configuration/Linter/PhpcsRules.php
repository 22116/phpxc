<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration\Linter;

use LSBProject\PHPXC\Configuration\MultiNodeInterface;
use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class PhpcsRules extends Enum implements MultiNodeInterface
{
    private const PSR2 = 'psr2';
    private const PSR12 = 'psr12';
    private const SYMFONY = 'symfony';
    private const LSBPROJECT = 'lsbproject';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::PSR2 => 'PSR-2',
            self::PSR12 => 'PSR-12',
            self::SYMFONY => 'Symfony',
            self::LSBPROJECT => 'LSBProject',
            default => throw new InvalidNodeException()
        };
    }
}
