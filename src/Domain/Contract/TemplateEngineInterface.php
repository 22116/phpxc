<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Contract;

use LSBProject\PHPXC\Domain\Exception\FilesystemException;
use RuntimeException;

interface TemplateEngineInterface
{
    public function loadTemplates(string $path): void;

    /**
     * @param array<string, mixed> $data
     *
     * @throws RuntimeException
     */
    public function render(string $template, array $data): string;

    /**
     * @param array<string, mixed> $data
     *
     * @throws RuntimeException
     * @throws FilesystemException
     */
    public function renderFile(string $path, array $data): string;
}
