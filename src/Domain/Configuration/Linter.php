<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration;

use LSBProject\PHPXC\Domain\Configuration\Linter\PhpcsRules;
use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Linter extends Enum implements MultiChoiceNodeInterface, DeepNodeInterface
{
    private const PHPCS = 'phpcs';

    /**
     * {@inheritdoc}
     */
    public function getChildren(): array
    {
        return match ($this->value) {
            self::PHPCS => [PhpcsRules::class],
            default => throw new InvalidNodeException()
        };
    }

    public function getDescription(): string
    {
        return match ($this->value) {
            self::PHPCS => 'PHPCS',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'Linting tool';
    }
}