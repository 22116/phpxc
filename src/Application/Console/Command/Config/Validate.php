<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Command\Config;

use LSBProject\PHPXC\Application\Console\Configuration\Validator;
use LSBProject\PHPXC\Application\Console\IOStyle;
use LSBProject\PHPXC\Application\Console\PathResolver;
use LSBProject\PHPXC\Constant;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Throwable;

final class Validate extends Command
{
    private const OPTION_TEMPLATE_PATH = 'template';

    public function __construct(private PathResolver $pathResolver, private Validator $validator)
    {
        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setName('config:validate')
            ->setDescription('Validate configuration tree')
            ->addOption(
                self::OPTION_TEMPLATE_PATH,
                't',
                InputOption::VALUE_REQUIRED,
                'Template path, git URL or installed template name',
                Constant::TEMPLATES_PATH . '/standard'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new IOStyle($input, $output);
        $path = $this->pathResolver->resolveTemplate($input->getOption(self::OPTION_TEMPLATE_PATH));

        try {
            $data = Yaml::parseFile($path->getConfiguration());

            $this->validator->validate($data);

            $io->success('Configuration is valid');
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
