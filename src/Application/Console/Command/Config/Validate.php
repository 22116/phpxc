<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Command\Config;

use LSBProject\PHPXC\Application\Console\Command\AbstractCommand;
use LSBProject\PHPXC\Application\Console\Configuration\Validator;
use LSBProject\PHPXC\Application\Console\IOStyle;
use LSBProject\PHPXC\Application\Console\PathResolver;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Throwable;

final class Validate extends AbstractCommand
{
    public function __construct(private PathResolver $pathResolver, private Validator $validator)
    {
        parent::__construct();
    }

    public function configure(): void
    {
        parent::configure();

        $this
            ->setName('config:validate')
            ->setDescription('Validate configuration tree')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new IOStyle($input, $output);

        try {
            $path = $this->pathResolver->resolveTemplate($input->getOption(self::OPTION_TEMPLATE_PATH));
            $data = Yaml::parseFile($path->getConfiguration());

            $this->validator->validate($data);

            $io->success('Configuration is valid');
        } catch (Throwable $exception) {
            $io->exception($exception);

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
