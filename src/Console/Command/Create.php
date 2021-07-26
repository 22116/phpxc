<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Console\Command;

use LSBProject\PHPXC\Configuration;
use LSBProject\PHPXC\Console\ConfigurationReader\Reader;
use LSBProject\PHPXC\Console\IOStyle;
use LSBProject\PHPXC\TemplateBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

final class Create extends Command
{
    private const ARGUMENT_PATH = 'path';

    public function __construct(private TemplateBuilder $templateBuilder)
    {
        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setName('create')
            ->setDescription('Create new project')
            ->setHelp('This command helps in base project setup. All options are configuring interactively.')
            ->addArgument(
                self::ARGUMENT_PATH,
                InputArgument::REQUIRED,
                'Path to a new project'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $reader = new Reader($input, $output);
        $nodes = $reader->read(Configuration::class);

        /** @var string $path */
        $path = $input->getArgument(self::ARGUMENT_PATH);
        $io = new IOStyle($input, $output);

        $io->clear();

        try {
            $this->templateBuilder->build($nodes, $path);
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());

            return self::FAILURE;
        }

        $io->success('Project successfully created! 🔥🔥🔥');

        return self::SUCCESS;
    }
}
