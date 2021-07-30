<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Command\Config;

use LSBProject\PHPXC\Application\Console\IOStyle;
use LSBProject\PHPXC\Application\Console\PathResolver;
use LSBProject\PHPXC\Constant;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

final class Show extends Command
{
    private const OPTION_TEMPLATE_PATH = 'template';

    public function __construct(private PathResolver $pathResolver)
    {
        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setName('config:show')
            ->setDescription('Show configuration tree')
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
        $path = $this->pathResolver->resolveTemplate($input->getOption(self::OPTION_TEMPLATE_PATH));

        try {
            $output->writeln((string) file_get_contents($path->getConfiguration()));
        } catch (Throwable $exception) {
            (new IOStyle($input, $output))->error($exception->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}