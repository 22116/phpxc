<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Infrastructure;

final class Util
{
    private function __construct()
    {
        // Disable creation
    }

    /**
     * @param mixed[] $a
     * @param mixed[] $b
     *
     * @return mixed[]
     */
    public static function mergeRecursivelyPreserveKeys(array $a, array $b): array
    {
        foreach ($b as $bKey => $bValue) {
            if (is_numeric($bKey)) {
                $a[] = !is_array($bValue) || !isset($a[$bKey])
                    ? $bValue
                    : self::mergeRecursivelyPreserveKeys($a[$bKey], $bValue);
            } else {
                $a[$bKey] = !is_array($bValue) || !isset($a[$bKey])
                    ? $bValue
                    : self::mergeRecursivelyPreserveKeys($a[$bKey], $bValue);
            }
        }

        return array_intersect_key($a, array_unique(array_map('serialize', $a)));
    }
}
