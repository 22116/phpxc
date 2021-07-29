<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Command;

use LSBProject\PHPXC\Application\Console\Configuration\Reader;
use LSBProject\PHPXC\Application\Console\Configuration\Validator;
use LSBProject\PHPXC\Application\Console\IOStyle;
use LSBProject\PHPXC\Constant;
use LSBProject\PHPXC\Domain\TemplateBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Throwable;

final class Create extends Command
{
    private const ARGUMENT_PATH = 'path';

    public function __construct(private TemplateBuilder $templateBuilder, private Validator $validator)
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
        /** @var string $path */
        $path = $input->getArgument(self::ARGUMENT_PATH);
        $io = new IOStyle($input, $output);
        $configurationReader = new Reader($input, $output);

        $io->clear();
        $io->info('Building the project');

        try {
            $data = Yaml::parseFile(Constant::CONFIGURATION_PATH);

            $this->validator->validate($data);
            $this->templateBuilder->build($configurationReader->read($data), $path);
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());

            if ($output->isVerbose()) {
                $io->writeln($exception->getTraceAsString());
            }

            return self::FAILURE;
        }

        $io->newLine();
        $io->success('Project successfully created! 🔥🔥🔥');

        return self::SUCCESS;
    }
}
