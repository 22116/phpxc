<?php

declare(strict_types=1);

namespace LSBProject\PHPXC;

use MyCLabs\Enum\Enum;

final class Type extends Enum
{
    private const LIBRARY = 'library';
    private const WEB = 'web';
    private const CLI = 'cli';
}
