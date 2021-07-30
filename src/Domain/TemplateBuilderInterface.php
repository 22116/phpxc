<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain;

use LSBProject\PHPXC\Domain\Exception\FilesystemException;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

interface TemplateBuilderInterface
{
    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws FilesystemException
     */
    public function build(NodeCollection $nodes, string $path, string $templatePath): void;
}
