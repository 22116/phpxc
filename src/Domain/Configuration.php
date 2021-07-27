<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain;

use LSBProject\PHPXC\Domain\Configuration as Types;
use LSBProject\PHPXC\Domain\Configuration\DeepNodeInterface;

final class Configuration implements DeepNodeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getChildren(): array
    {
        return [
            Types\Composer\Name::class,
            Types\Composer\Description::class,
            Types\Composer\License::class,
            Types\Composer\PhpVersion::class,
            Types\Type::class,
            Types\Linter::class,
            Types\StaticAnalyzer::class,
            Types\Testing::class,
            Types\ContinuousIntegration::class,
        ];
    }

    public static function getTitle(): string
    {
        return 'Root';
    }
}
