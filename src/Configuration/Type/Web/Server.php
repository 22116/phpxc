<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration\Type\Web;

use LSBProject\PHPXC\Configuration\ChoiceNodeInterface;
use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Server extends Enum implements ChoiceNodeInterface
{
    private const EMBEDDED = 'embedded';
    private const APACHE = 'apache';
    private const NGINX = 'nginx';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::EMBEDDED => 'Embedded',
            self::APACHE => 'Apache',
            self::NGINX => 'Nginx',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'Server';
    }
}
