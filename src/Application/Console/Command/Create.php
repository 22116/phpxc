<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Command;

use LSBProject\PHPXC\Application\Console\Configuration\Reader;
use LSBProject\PHPXC\Application\Console\Configuration\Validator;
use LSBProject\PHPXC\Application\Console\IOStyle;
use LSBProject\PHPXC\Application\Console\PathResolver;
use LSBProject\PHPXC\Domain\ShellTemplateBuilder;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Throwable;

final class Create extends AbstractCommand
{
    private const ARGUMENT_PATH = 'path';

    public function __construct(
        private PathResolver $pathResolver,
        private ShellTemplateBuilder $templateBuilder,
        private Validator $validator
    ) {
        parent::__construct();
    }

    public function configure(): void
    {
        parent::configure();

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
        $io = new IOStyle($input, $output);

        try {
            $path = $this->pathResolver->resolve($input->getArgument(self::ARGUMENT_PATH));
            $templatePath = $this->pathResolver->resolveTemplate($input->getOption(self::OPTION_TEMPLATE_PATH));

            $configurationReader = new Reader($input, $output);

            $io->clear();

            $data = Yaml::parseFile($templatePath->getConfiguration());

            $this->validator->validate($data);

            $nodes = $configurationReader->read($data);

            $io->clear();
            $io->info('Building the project 🏗️');

            $this->templateBuilder->build($nodes, $path, $templatePath->getTemplate());
        } catch (Throwable $exception) {
            $io->exception($exception);

            return self::FAILURE;
        }

        $io->newLine();
        $io->success('Project successfully created! 🔥🔥🔥');

        return self::SUCCESS;
    }
}
