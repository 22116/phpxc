<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration;

use LSBProject\PHPXC\Configuration\Composer\Description;
use LSBProject\PHPXC\Configuration\Composer\License;
use LSBProject\PHPXC\Configuration\Composer\Name;
use LSBProject\PHPXC\Configuration\Composer\PhpVersion;

final class Composer implements DeepNodeInterface
{
    public static function getTitle(): string
    {
        return 'Composer';
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren(): array
    {
        return [
            Name::class,
            Description::class,
            PhpVersion::class,
            License::class,
        ];
    }
}
