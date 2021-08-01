<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Infrastructure;

use FilesystemIterator;
use LSBProject\PHPXC\Domain\Contract\FilesystemInterface;
use LSBProject\PHPXC\Domain\Exception\ShellException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

final class Filesystem implements FilesystemInterface
{
    /**
     * {@inheritdoc}
     */
    public function removeEmptyDirectories(string $path, array $ignoreList = []): void
    {
//        echo PHP_EOL;
        $dirIterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)
        );

        /** @var SplFileInfo $directory */
        foreach ($dirIterator as $directory) {
//            echo 'Found: ' . $directory->getPathname() . PHP_EOL;
            $ignore = false;

            foreach ($ignoreList as $expression) {
                if (preg_match($expression, $directory->getPathname())) {
                    $ignore = true;

                    break;
                }
            }

            if (!$ignore && $directory->isDir() && $this->isEmpty($directory->getPathname())) {
//                echo 'IS EMPTY!';
                $this->removeDirectory($directory->getPathname());
            }
        }
    }

    public function removeDirectory(string $path): void
    {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            rmdir($fileinfo->getRealPath());
        }

        rmdir($path);
    }

    public function makeDirectory(string $path): void
    {
        if (!@mkdir($path, 02775, true) && !is_dir($path)) {
            throw new ShellException(sprintf('Directory "%s" was not created', $path));
        }
    }

    public function writeToFile(string $file, string $data): void
    {
        file_put_contents($file, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function iterateDirectories(string $path): iterable
    {
        return new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    }

    public function readFile(string $path): string
    {
        return file_get_contents($path) ?: '';
    }

    public function isFile(string $path): bool
    {
        return is_file($path);
    }

    public function isDirectory(string $path): bool
    {
        return is_dir($path);
    }

    /**
     * @return string[]
     */
    public function findFileNames(string $path): array
    {
        return @scandir($path) ?: [];
    }

    private function isEmpty(string $path): bool
    {
        $dirIterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)
        );

        /** @var SplFileInfo $directory */
        foreach ($dirIterator as $directory) {
            if ($directory->isFile()) {
                return false;
            }
        }

        return true;
    }
}
