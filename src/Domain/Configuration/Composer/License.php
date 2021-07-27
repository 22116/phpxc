<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration\Composer;

use LSBProject\PHPXC\Domain\Configuration\ChoiceNodeInterface;
use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class License extends Enum implements ChoiceNodeInterface
{
    private const NONE = 'none';
    private const APACHE2 = 'apache-2.0';
    private const WTFPL = 'wtfpl';
    private const MIT = 'mit';
    private const GPLV2 = 'GPLv2';
    private const GPLV3 = 'GPLv3';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::NONE => 'None',
            self::MIT => 'MIT',
            self::GPLV2 => 'GNU General Public License v2.0',
            self::GPLV3 => 'GNU General Public License v3.0',
            self::APACHE2 => 'Apache license 2.0',
            self::WTFPL => 'Do What The F*ck You Want To Public License',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'License';
    }
}
