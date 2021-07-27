<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Infrastructure;

use LSBProject\PHPXC\Domain\Contract\ShellExecutorInterface;
use LSBProject\PHPXC\Domain\Exception\ShellException;

final class ShellExecutor implements ShellExecutorInterface
{
    public function execute(string $command, string $error = 'Failure'): void
    {
        if (false === system($command)) {
            throw new ShellException("$error. '$command'");
        }
    }
}
