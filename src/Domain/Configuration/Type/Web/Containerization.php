<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration\Type\Web;

use LSBProject\PHPXC\Domain\Configuration\Containerization as Base;
use LSBProject\PHPXC\Domain\Configuration\DeepNodeInterface;
use LSBProject\PHPXC\Domain\Configuration\Type\Web\Containerization\Cache;
use LSBProject\PHPXC\Domain\Configuration\Type\Web\Containerization\MessageBroker;
use LSBProject\PHPXC\Domain\Configuration\Type\Web\Containerization\Server;
use LSBProject\PHPXC\Domain\Configuration\Type\Web\Containerization\Storage;
use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;

final class Containerization extends Base implements DeepNodeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getChildren(): array
    {
        return match ($this->value) {
            self::NONE => [],
            self::DOCKER => [
                Server::class,
                Storage::class,
                Cache::class,
                MessageBroker::class,
            ],
            default => throw new InvalidNodeException()
        };
    }
}
