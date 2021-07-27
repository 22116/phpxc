<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration;

use LSBProject\PHPXC\Domain\Configuration\Type\Cli;
use LSBProject\PHPXC\Domain\Configuration\Type\Library;
use LSBProject\PHPXC\Domain\Configuration\Type\Web;
use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Type extends Enum implements ChoiceNodeInterface, DeepNodeInterface
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
                Web\Framework::class,
                Web\Containerization::class,
            ],
            self::CLI => [
                Cli\BinaryName::class,
                Cli\Framework::class,
                Cli\Type::class,
                Containerization::class,
            ],
            self::LIBRARY => [
                Library\NamespaceName::class,
                Library\Type::class,
                Containerization::class,
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

    public static function getTitle(): string
    {
        return 'Application type';
    }
}
