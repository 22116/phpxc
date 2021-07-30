<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Infrastructure;

use CzProject\GitPhp\Git as Gateway;
use CzProject\GitPhp\GitException;

final class Git
{
    public function __construct(private Gateway $git)
    {
    }

    /**
     * @throws GitException
     */
    public function clone(string $url, string $path): string
    {
        $matches = [];

        preg_match('/\/([^\/]*)\.git$/', $url, $matches);

        $repositoryPath = $path . '/' . $matches[1];

        try {
            $this->git->cloneRepository($url, $repositoryPath);
        } catch (GitException) {
            $this->git->open($repositoryPath)->pull();
        }

        return $repositoryPath;
    }
}
