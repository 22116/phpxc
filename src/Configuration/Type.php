<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration;

use LSBProject\PHPXC\Configuration\Type\Cli;
use LSBProject\PHPXC\Configuration\Type\Library;
use LSBProject\PHPXC\Configuration\Type\Web;
use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Type extends Enum implements DeepNodeInterface
{
    private const LIBRARY = 'library';
    private const WEB = 'web';
    private const CLI = 'cli';

    /**
     * {@inheritdoc}
     */
    public function getChildren(): array
    {
        return match ($this->value) {
            self::WEB => [
                Web\Server::class,
                Web\Storage::class,
                Web\Cache::class,
                Web\MessageBroker::class,
                Web\Framework::class,
            ],
            self::CLI => [
                Cli\Framework::class,
                Cli\Type::class,
            ],
            self::LIBRARY => [
                Library\Type::class,
            ],
            default => throw new InvalidNodeException()
        };
    }

    public function getDescription(): string
    {
        return match ($this->value) {
            self::WEB => 'Web Application',
            self::CLI => 'Command Line Interface',
            self::LIBRARY => 'Library',
            default => throw new InvalidNodeException()
        };
    }
}
