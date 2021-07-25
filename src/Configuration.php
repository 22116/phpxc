<?php

declare(strict_types=1);

namespace LSBProject\PHPXC;

use LSBProject\PHPXC\Configuration\Containerization;
use LSBProject\PHPXC\Configuration\ContinuousIntegration;
use LSBProject\PHPXC\Configuration\DeepNodeInterface;
use LSBProject\PHPXC\Configuration\Linter;
use LSBProject\PHPXC\Configuration\PhpVersion;
use LSBProject\PHPXC\Configuration\StaticAnalyzer;
use LSBProject\PHPXC\Configuration\Type;

final class Configuration implements DeepNodeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getChildren(): array
    {
        return [
            PhpVersion::class,
            Type::class,
            Linter::class,
            StaticAnalyzer::class,
            Containerization::class,
            ContinuousIntegration::class,
        ];
    }

    public function getDescription(): string
    {
        return 'Root configuration object';
    }

    /**
     * {@inheritdoc}
     */
    public static function values(): array
    {
        return [];
    }

    public static function getTitle(): string
    {
        return 'Root';
    }
}
