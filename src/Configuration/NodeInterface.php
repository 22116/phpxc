<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration;

interface NodeInterface
{
    public static function getTitle(): string;
    public function getDescription(): string;

    /**
     * {@inheritdoc}
     *
     * @return static[]
     */
    public static function values();
}
