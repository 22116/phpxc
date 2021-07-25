<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration\Composer;

use LSBProject\PHPXC\Configuration\AbstractTextNode;

final class Name extends AbstractTextNode
{
    public static function getTitle(): string
    {
        return 'Project name (example: lsbproject/my-new-project)';
    }
}
