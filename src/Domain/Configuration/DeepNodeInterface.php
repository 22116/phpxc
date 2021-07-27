<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration;

interface DeepNodeInterface extends NodeInterface
{
    /**
     * @return array<class-string<NodeInterface>>
     */
    public function getChildren(): array;
}
