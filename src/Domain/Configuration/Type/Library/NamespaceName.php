<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration\Type\Library;

use LSBProject\PHPXC\Domain\Configuration\AbstractTextNode;

final class NamespaceName extends AbstractTextNode
{
    public static function getTitle(): string
    {
        return 'Namespace name (example: AcmeApp)';
    }
}
