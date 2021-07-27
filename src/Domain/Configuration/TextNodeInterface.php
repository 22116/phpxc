<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration;

interface TextNodeInterface extends NodeInterface
{
    public function setText(string $value): void;
    public function getText(): string;
}