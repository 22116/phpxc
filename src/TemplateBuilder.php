<?php

declare(strict_types=1);

namespace LSBProject\PHPXC;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use SplFileInfo;
use Twig\Environment;
use Twig\Error;

final class TemplateBuilder
{
    public function __construct(private Environment $twig)
    {
    }

    /**
     * @throws Error\LoaderError
     * @throws Error\RuntimeError
     * @throws Error\SyntaxError
     */
    public function build(NodeCollection $nodes, string $path): void
    {
        $templatesPath = __DIR__ . '/../templates/';
        $dirIterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($templatesPath)
        );

        if (is_dir($path)) {
            throw new RuntimeException('Directory already exists');
        }

        $this->makeDirectory($path);

        /** @var SplFileInfo $directory */
        foreach ($dirIterator as $directory) {
            $templateName = str_replace($templatesPath, '', $directory->getPathname());
            $fsName = str_replace('.twig', '', "$path/$templateName");

            if ($directory->isDir()) {
                $this->makeDirectory($fsName);
            } else {
                $data = $this->twig->render($templateName, ['nodes' => $nodes]);

                file_put_contents($fsName, $data);
            }
        }
    }

    private function makeDirectory(string $pathname): void
    {
        if (!@mkdir($pathname, 02775, true) && !is_dir($pathname)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $pathname));
        }
    }
}
