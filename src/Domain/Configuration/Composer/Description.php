<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration\Composer;

use LSBProject\PHPXC\Domain\Configuration\AbstractTextNode;

final class Description extends AbstractTextNode
{
    public static function getTitle(): string
    {
        return 'Description';
    }
}
