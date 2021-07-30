<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain;

use LSBProject\PHPXC\Domain\Contract\FilesystemInterface;
use SplFileInfo;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class TemplateBuilder implements TemplateBuilderInterface
{
    public function __construct(private FilesystemInterface $filesystem)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function build(NodeCollection $nodes, string $path, string $templatePath): void
    {
        if (!is_dir($path)) {
            $this->filesystem->makeDirectory($path);
        }

        $twig = new Environment(new FilesystemLoader($templatePath));
        $dirIterator = $this->filesystem->iterateDirectories($templatePath);

        /** @var SplFileInfo $directory */
        foreach ($dirIterator as $directory) {
            $templateName = str_replace($templatePath, '', $directory->getPathname());
            $fsName = str_replace('.twig', '', "$path/$templateName");

            if ($directory->isDir()) {
                $this->filesystem->makeDirectory($fsName);
            } else {
                $data = $twig->render($templateName, ['nodes' => $nodes->toArray()]);

                if (trim($data)) {
                    $this->filesystem->writeToFile($fsName, $data);
                }
            }
        }

        $this->filesystem->removeEmptyDirectories($path);
    }
}
