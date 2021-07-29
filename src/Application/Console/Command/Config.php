<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Command;

use LSBProject\PHPXC\Constant;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Config extends Command
{
    public function configure(): void
    {
        $this
            ->setName('config')
            ->setDescription('Show configuration tree')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln((string) file_get_contents(Constant::CONFIGURATION_PATH));

        return self::SUCCESS;
    }
}
