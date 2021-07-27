<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Contract;

use LSBProject\PHPXC\Domain\Exception\ShellException;

interface ShellExecutorInterface
{
    /**
     * @throws ShellException
     */
    public function execute(string $command, string $error = 'Failure'): void;
}
