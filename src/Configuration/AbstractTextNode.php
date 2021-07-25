<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration;

abstract class AbstractTextNode implements TextNodeInterface
{
    protected string $text = '';

    public function setText(string $value): void
    {
        $this->text = $value;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
