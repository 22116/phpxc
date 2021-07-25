<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration\Type\Web;

use LSBProject\PHPXC\Configuration\NodeInterface;
use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Server extends Enum implements NodeInterface
{
    private const EMBEDED = 'embeded';
    private const APACHE = 'apache';
    private const NGINX = 'nginx';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::EMBEDED => 'Embeded',
            self::APACHE => 'Apache',
            self::NGINX => 'Nginx',
            default => throw new InvalidNodeException()
        };
    }
}
