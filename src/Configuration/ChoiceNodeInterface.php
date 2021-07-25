<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration;

interface ChoiceNodeInterface extends NodeInterface
{
    /**
     * {@inheritdoc}
     *
     * @return static[]
     */
    public static function values();

    public function getDescription(): string;
}
