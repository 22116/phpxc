<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Exception;

use RuntimeException;

final class ShellException extends RuntimeException
{
    public function execute(string $command, string $error = 'Failure'): void
    {
        if (false === system($command)) {
            throw new RuntimeException("$error. '$command'");
        }
    }
}
