<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration\Type\Web\Containerization;

use LSBProject\PHPXC\Domain\Configuration\MultiChoiceNodeInterface;
use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Storage extends Enum implements MultiChoiceNodeInterface
{
    private const MYSQL = 'mysql';
    private const MARIADB = 'mariadb';
    private const CLICKHOUSE = 'clickhouse';
    private const POSTGRESQL = 'postrgesql';
    private const MONGODB = 'mongodb';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::MYSQL => 'MySQL',
            self::MARIADB => 'MariaDB',
            self::CLICKHOUSE => 'ClickHouse',
            self::POSTGRESQL => 'PostgreSQL',
            self::MONGODB => 'MongoDB',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'Storages';
    }
}
