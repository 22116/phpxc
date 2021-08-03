<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain;

use JsonException;
use LSBProject\PHPXC\Domain\Contract\FilesystemInterface;
use LSBProject\PHPXC\Domain\Contract\TemplateEngineInterface;
use LSBProject\PHPXC\Domain\Util\DataStructure;
use SplFileInfo;

final class TemplateBuilder implements TemplateBuilderInterface
{
    private const COMPOSER_ITEMS_ORDER = [
        'name',
        'description',
        'version',
        'type',
        'bin',
        'license',
        'minimum-stability',
        'prefer-stable',
        'require',
        'require-dev',
        'autoload',
        'autoload-dev',
        'config',
        'replace',
        'scripts',
        'conflict',
        'extra',
    ];

    public function __construct(
        private FilesystemInterface $filesystem,
        private TemplateEngineInterface $templateEngine
    ) {
    }

    /**
     * {@inheritdoc}
     *
     * @throws JsonException
     */
    public function build(Configuration $configuration, string $path, string $templatePath): void
    {
        if (!$this->filesystem->isDirectory($path)) {
            $this->filesystem->makeDirectory($path);
        }

        $this->templateEngine->loadTemplates($templatePath);

        $dirIterator = $this->filesystem->iterateDirectories($templatePath);
        $templateData = ['nodes' => $configuration->getNodes()->toArray()];

        /** @var SplFileInfo $directory */
        foreach ($dirIterator as $directory) {
            $originTemplateName = str_replace($templatePath, '', $directory->getPathname());
            $templateName = $this->templateEngine->render($originTemplateName, $templateData);

            if ('/' === substr(str_replace('.twig', '', $templateName), -1)) {
                continue;
            }

            $fsName = str_replace('.twig', '', "$path/$templateName");

            if ($directory->isDir()) {
                $this->filesystem->makeDirectory($fsName);
            } else {
                $data = $this->templateEngine->renderFile($originTemplateName, $templateData);

                if (trim($data) || str_contains($templateName, '.gitignore')) {
                    if (str_contains($fsName, 'composer.json') && $this->filesystem->isFile($fsName)) {
                        $data = DataStructure::mergeJson(
                            $this->filesystem->readFile($fsName),
                            $data,
                            self::COMPOSER_ITEMS_ORDER
                        );
                    }

                    $this->filesystem->writeToFile($fsName, $data);
                }
            }
        }

        if ($configuration->isRemoveEmptyDirectories()) {
            $this->filesystem->removeEmptyDirectories($path, $configuration->getDirectoryIgnoreList());
        }
    }
}
