<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Infrastructure\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class NamespaceExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('namespace', [$this, 'format']),
        ];
    }

    public function format(string $namespace): string
    {
        return trim(str_replace('\\\\', '\\', $namespace), '\\');
    }
}
