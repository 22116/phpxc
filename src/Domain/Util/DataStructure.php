<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Util;

use JsonException;

final class DataStructure
{
    private function __construct()
    {
        // Disable creation
    }

    /**
     * @param string[] $orders
     *
     * @throws JsonException
     */
    public static function mergeJson(string $source, string $target, array $orders = []): string
    {
        $source = json_decode(
            $source,
            true,
            512,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
        $target = json_decode(
            $target,
            true,
            512,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );

        $data = self::mergeRecursivelyPreserveKeys($source, $target);

        uksort($data, static function (string $a, string $b) use ($orders) {
            $values = array_flip($orders);

            if (!in_array($a, $orders, true) && !in_array($b, $orders, true)) {
                return -1;
            }

            if (in_array($a, $orders, true) && !in_array($b, $orders, true)) {
                return 1;
            }

            if (in_array($a, $orders, true) && in_array($b, $orders, true)) {
                return $values[$a] > $values[$b] ? 1 : -1;
            }

            return 1;
        });

        return json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
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
