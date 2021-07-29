<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration;

use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class TextNode extends Node
{
    /**
     * @param Script[] $preScripts
     * @param Script[] $postScripts
     */
    #[Pure]
    public function __construct(
        private string $text = '',
        string $description = '',
        protected array $preScripts = [],
        protected array $postScripts = [],
    ) {
        parent::__construct(
            $description,
            $preScripts,
            $postScripts
        );
    }

    public function getText(): string
    {
        return $this->text;
    }
}
