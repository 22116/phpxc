<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console;

use Symfony\Component\Console\Style\SymfonyStyle;

final class IOStyle extends SymfonyStyle
{
    /**
     * {@inheritdoc}
     *
     * @param string|string[] $message
     */
    public function error($message): void
    {
        $this->block($message, 'ERROR', 'fg=black;bg=red', ' ', true);
    }

    public function clear(): void
    {
        $this->write("\033\143");
    }
}
