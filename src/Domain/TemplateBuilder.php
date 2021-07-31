<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain;

use JsonException;
use LSBProject\PHPXC\Domain\Contract\FilesystemInterface;
use LSBProject\PHPXC\Infrastructure\Util;
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
     *
     * @throws JsonException
     */
    public function build(NodeCollection $nodes, string $path, string $templatePath): void
    {
        if (!$this->filesystem->isDirectory($path)) {
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
                    if (str_contains($fsName, 'composer.json') && $this->filesystem->isFile($fsName)) {
                        $data = $this->mergeJson($this->filesystem->readFile($fsName), $data, [
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
                        ]);
                    }

                    $this->filesystem->writeToFile($fsName, $data);
                }
            }
        }

        $this->filesystem->removeEmptyDirectories($path);
    }

    /**
     * @param string[] $orders
     *
     * @throws JsonException
     */
    private function mergeJson(string $source, string $target, array $orders = []): string
    {
        $source = json_decode(
            $source,
            true,
            512,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
        $target = json_decode(
            $target,
            true,
            512,
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );

        $data = Util::mergeRecursivelyPreserveKeys($source, $target);

        uksort($data, static function (string $a, string $b) use ($orders) {
            $values = array_flip($orders);

            if (!in_array($a, $orders, true) && !in_array($b, $orders, true)) {
                return -1;
            }

            if (in_array($a, $orders, true) && !in_array($b, $orders, true)) {
                return 1;
            }

            if (in_array($a, $orders, true) && in_array($b, $orders, true)) {
                return $values[$a] > $values[$b] ? 1 : -1;
            }

            return 1;
        });

        return json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }
}
