<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain;

use LSBProject\PHPXC\Domain\Configuration\Linter;
use LSBProject\PHPXC\Domain\Configuration\StaticAnalyzer;
use LSBProject\PHPXC\Domain\Configuration\Testing;
use LSBProject\PHPXC\Domain\Configuration\Type\Web\Framework;
use LSBProject\PHPXC\Domain\Contract\ShellExecutorInterface;

final class ScriptExecutor
{
    public function __construct(private ShellExecutorInterface $executor)
    {
    }

    public function before(NodeCollection $nodes, string $path): void
    {
        if ($nodes->has(Framework::SYMFONY())) {
            $this->executor->execute("composer create-project symfony/skeleton $path");
        }
    }

    public function after(NodeCollection $nodes, string $path): void
    {
        $this->executor->execute("composer update -d $path --ignore-platform-reqs", 'Cannot install dependencies');

        if ($nodes->has(Linter::PHPCS())) {
            $this->executor->execute("composer require -d $path --dev squizlabs/php_codesniffer");

            if ($nodes->has(Linter\PhpcsRules::SYMFONY())) {
                $this->executor->execute("composer require -d $path --dev escapestudios/symfony2-coding-standard");
            }

            if ($nodes->has(Linter\PhpcsRules::LSBPROJECT())) {
                $this->executor->execute("composer require -d $path --dev lsbproject/php-clean-code-rules");
            }
        }

        if ($nodes->has(StaticAnalyzer::PHPSTAN())) {
            $this->executor->execute("composer require -d $path --dev phpstan/phpstan");

            if ($nodes->has(Framework::SYMFONY())) {
                $this->executor->execute("composer require -d $path --dev phpstan/phpstan-symfony");
            }
        }

        if ($nodes->has(Testing::PHPUNIT())) {
            $this->executor->execute("composer require -d $path --dev phpunit/phpunit");
        }
    }
}
