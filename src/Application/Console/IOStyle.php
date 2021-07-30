<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console;

use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

final class IOStyle extends SymfonyStyle
{
    public function exception(Throwable $exception): void
    {
        $this->error($exception->getMessage());

        if ($this->isVerbose()) {
            $this->writeln($exception->getTraceAsString());
        }
    }

    public function clear(): void
    {
        $this->write("\033\143");
    }
}
