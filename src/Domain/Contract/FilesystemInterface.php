<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Contract;

use LSBProject\PHPXC\Domain\Exception\FilesystemException;
use SplFileInfo;

interface FilesystemInterface
{
    /**
     * @return iterable<SplFileInfo>
     */
    public function iterateDirectories(string $path): iterable;

    /**
     * @param string[] $ignoreList
     *
     * @throws FilesystemException
     */
    public function removeEmptyDirectories(string $path, array $ignoreList = []): void;

    /**
     * @throws FilesystemException
     */
    public function removeDirectory(string $path): void;

    /**
     * @throws FilesystemException
     */
    public function makeDirectory(string $path): void;

    /**
     * @throws FilesystemException
     */
    public function writeToFile(string $file, string $data): void;

    public function readFile(string $path): string;
    public function isFile(string $path): bool;
    public function isDirectory(string $path): bool;
}
