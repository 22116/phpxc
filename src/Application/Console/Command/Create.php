<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Command;

use LSBProject\PHPXC\Application\Console\Configuration\Reader;
use LSBProject\PHPXC\Application\Console\Configuration\Validator;
use LSBProject\PHPXC\Application\Console\IOStyle;
use LSBProject\PHPXC\Constant;
use LSBProject\PHPXC\Domain\ShellTemplateBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Throwable;

final class Create extends Command
{
    private const ARGUMENT_PATH = 'path';
    private const OPTION_TEMPLATE_PATH = 'template';

    public function __construct(private ShellTemplateBuilder $templateBuilder, private Validator $validator)
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
            ->addOption(
                self::OPTION_TEMPLATE_PATH,
                't',
                InputOption::VALUE_REQUIRED,
                'Template path',
                Constant::TEMPLATES_PATH . '/standard'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $path */
        $path = $input->getArgument(self::ARGUMENT_PATH);

        /** @var string $templatePath */
        $templatePath = $input->getOption(self::OPTION_TEMPLATE_PATH);

        $io = new IOStyle($input, $output);
        $configurationReader = new Reader($input, $output);

        $io->clear();

        try {
            $data = Yaml::parseFile($templatePath . '/config.yaml');

            $this->validator->validate($data);

            $nodes = $configurationReader->read($data);

            $io->info('Building the project');

            $this->templateBuilder->build($nodes, $path, $templatePath . '/template');
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
