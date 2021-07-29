<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration;

interface NodeInterface
{
    public function getDescription(): string;

    /**
     * @return Script[]
     */
    public function getPreScripts(): array;

    /**
     * @return Script[]
     */
    public function getPostScripts(): array;

    public function getParentName(): string;
}
