<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console;

use Exception;
use InvalidArgumentException;
use JetBrains\PhpStorm\Pure;
use LSBProject\PHPXC\Constant;
use LSBProject\PHPXC\Infrastructure\Filesystem;
use LSBProject\PHPXC\Infrastructure\Git;

final class PathResolver
{
    public function __construct(private Filesystem $filesystem, private Git $git)
    {
    }

    #[Pure]
    public function resolve(string $path): string
    {
        return realpath($path) ?: '';
    }

    /**
     * @throws Exception
     */
    public function resolveTemplate(string $path): TemplatePath
    {
        if (filter_var($path, FILTER_VALIDATE_URL) && '.git' === substr($path, -4)) {
            $path = $this->git->clone($path, Constant::TEMPLATES_PATH);
        } elseif (in_array($path, $this->filesystem->findFileNames(Constant::TEMPLATES_PATH))) {
            $path = Constant::TEMPLATES_PATH . '/' . $path;
        }

        $path = $this->resolve($path);

        if (!$path) {
            throw new InvalidArgumentException('No template found');
        }

        return new TemplatePath($path);
    }
}
