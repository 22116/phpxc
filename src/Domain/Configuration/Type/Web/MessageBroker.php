<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain\Configuration\Type\Web;

use LSBProject\PHPXC\Domain\Configuration\ChoiceNodeInterface;
use LSBProject\PHPXC\Domain\Exception\InvalidNodeException;
use MyCLabs\Enum\Enum;

final class MessageBroker extends Enum implements ChoiceNodeInterface
{
    private const NONE = 'none';
    private const RABBITMQ = 'rabbitmq';
    private const KAFKA = 'kafka';

    public function getDescription(): string
    {
        return match ($this->value) {
            self::NONE => 'None',
            self::RABBITMQ => 'RabbitMQ',
            self::KAFKA => 'Kafka',
            default => throw new InvalidNodeException()
        };
    }

    public static function getTitle(): string
    {
        return 'Message Broker tool';
    }
}
