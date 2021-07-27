<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration;

use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class ContinuousIntegration extends Enum implements ChoiceNodeInterface
{
    private const NONE = 'none';
    private const GITHUB = 'github';
    private const GITLAB = 'gitlab';
    private const TRAVIS = 'travis';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::NONE => 'None',
            self::GITHUB => 'GitHub Actions',
            self::GITLAB => 'GitLab CI',
            self::TRAVIS => 'Travis CI',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'Continuous Integration';
    }
}
