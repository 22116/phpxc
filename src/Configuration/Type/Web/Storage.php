<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Configuration\Type\Web;

use LSBProject\PHPXC\Configuration\NodeInterface;
use LSBProject\PHPXC\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class Storage extends Enum implements NodeInterface
{
    private const NONE = 'none';
    private const MYSQL = 'mysql';
    private const MARIADB = 'mariadb';
    private const CLICKHOUSE = 'clickhouse';
    private const POSTGRESQL = 'postrgesql';
    private const MONGODB = 'mongodb';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::NONE => 'None',
            self::MYSQL => 'MySQL',
            self::MARIADB => 'MariaDB',
            self::CLICKHOUSE => 'ClickHouse',
            self::POSTGRESQL => 'PostgreSQL',
            self::MONGODB => 'MongoDB',
            default => throw new InvalidNodeException()
        };
    }
}
