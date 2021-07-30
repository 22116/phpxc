<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Command\Config;

use LSBProject\PHPXC\Application\Console\Command\AbstractCommand;
use LSBProject\PHPXC\Application\Console\IOStyle;
use LSBProject\PHPXC\Application\Console\PathResolver;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

final class Show extends AbstractCommand
{
    public function __construct(private PathResolver $pathResolver)
    {
        parent::__construct();
    }

    public function configure(): void
    {
        parent::configure();

        $this
            ->setName('config:show')
            ->setDescription('Show configuration tree')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $path = $this->pathResolver->resolveTemplate($input->getOption(self::OPTION_TEMPLATE_PATH));

            $output->writeln((string) file_get_contents($path->getConfiguration()));
        } catch (Throwable $exception) {
            (new IOStyle($input, $output))->exception($exception);

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
