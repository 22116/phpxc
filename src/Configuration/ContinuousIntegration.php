<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration;

use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class ContinuousIntegration extends Enum implements NodeInterface
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
}
