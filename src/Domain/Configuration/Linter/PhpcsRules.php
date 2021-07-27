<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration\Linter;

use LSBProject\PHPXC\Domain\Configuration\MultiChoiceNodeInterface;
use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class PhpcsRules extends Enum implements MultiChoiceNodeInterface
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

    public static function getTitle(): string
    {
        return 'PHPCS rules';
    }
}
