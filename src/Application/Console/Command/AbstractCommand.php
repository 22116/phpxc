<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Command;

use LSBProject\PHPXC\Constant;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractCommand extends Command
{
    protected const OPTION_TEMPLATE_PATH = 'template';

    public function configure(): void
    {
        $this
            ->addOption(
                self::OPTION_TEMPLATE_PATH,
                't',
                InputOption::VALUE_REQUIRED,
                'Template path, git URL or installed template name',
                Constant::TEMPLATES_PATH . '/standard'
            )
        ;
    }
}
