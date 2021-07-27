<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration\Type\Cli;

use LSBProject\PHPXC\Domain\Configuration\AbstractTextNode;

final class BinaryName extends AbstractTextNode
{
    public static function getTitle(): string
    {
        return 'Binary name';
    }
}
