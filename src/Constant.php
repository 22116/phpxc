<?php

declare(strict_types=1);

namespace LSBProject\PHPXC;

final class Constant
{
    public const ROOT_PATH = __DIR__ . '/../';
    public const CONFIGURATION_PATH = self::ROOT_PATH . '/config/nodes.yaml';
    public const TEMPLATES_PATH = self::ROOT_PATH . '/templates';

    private function __construct()
    {
        // Disabled
    }
}
