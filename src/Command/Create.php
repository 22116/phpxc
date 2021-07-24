<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Command;

use LSBProject\PHPXC\Type;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Create extends Command
{
    private const ARGUMENT_TYPE = 'type';

    public function configure(): void
    {
        $this
            ->setName('create')
            ->setDescription('')
            ->addArgument(
                self::ARGUMENT_TYPE,
                InputArgument::REQUIRED,
                implode(' | ', Type::toArray())
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return self::SUCCESS;
    }
}
