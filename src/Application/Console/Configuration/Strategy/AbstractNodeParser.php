<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Configuration\Strategy;

use LSBProject\PHPXC\Domain\Configuration\Script;

abstract class AbstractNodeParser implements NodeParserStrategyInterface
{
    /**
     * @param string[]|array<string, mixed> $scripts
     *
     * @return Script[]
     */
    protected function readScripts(array $scripts): array
    {
        return array_map(static function (string|array $script) {
            if (is_string($script)) {
                return new Script($script);
            }

            return new Script($script['script'], $script['includes'] ?? [], $script['excludes'] ?? []);
        }, $scripts);
    }
}
