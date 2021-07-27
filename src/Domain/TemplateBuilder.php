<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain;

use LSBProject\PHPXC\Domain\Contract\FilesystemInterface;
use LSBProject\PHPXC\Domain\Exception\FilesystemException;
use SplFileInfo;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class TemplateBuilder
{
    private const TEMPLATE_PATH = __DIR__ . '/../../templates/';

    public function __construct(private Environment $twig, private FilesystemInterface $filesystem)
    {
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws FilesystemException
     */
    public function build(NodeCollection $nodes, string $path): void
    {
        if (!is_dir($path)) {
            $this->filesystem->makeDirectory($path);
        }

        $dirIterator = $this->filesystem->iterateDirectories(self::TEMPLATE_PATH);

        /** @var SplFileInfo $directory */
        foreach ($dirIterator as $directory) {
            $templateName = str_replace(self::TEMPLATE_PATH, '', $directory->getPathname());
            $fsName = str_replace('.twig', '', "$path/$templateName");

            if ($directory->isDir()) {
                $this->filesystem->makeDirectory($fsName);
            } else {
                $data = $this->twig->render($templateName, ['nodes' => $nodes]);

                if (trim($data)) {
                    $this->filesystem->writeToFile($fsName, $data);
                }
            }
        }

        $this->filesystem->removeEmptyDirectories($path);
    }
}
