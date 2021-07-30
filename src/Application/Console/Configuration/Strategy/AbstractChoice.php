<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Configuration\Strategy;

use JetBrains\PhpStorm\ArrayShape;
use LSBProject\PHPXC\Application\Console\Configuration\Validator;
use LSBProject\PHPXC\Application\Console\IOStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractChoice extends AbstractNodeParser
{
    public function __construct(protected InputInterface $input, protected OutputInterface $output)
    {
    }

    /**
     * @param mixed[] $node
     *
     * @return string[]
     */
    protected function buildQuestion(
        #[ArrayShape([
            Validator::DESCRIPTION => 'string',
            Validator::OPTIONS => 'array<string, string>',
        ])] array $node,
        string $question
    ): array {
        $style = new IOStyle($this->input, $this->output);
        $style->clear();
        $style->writeln($node[Validator::DESCRIPTION]);
        $style->writeln($question);
        $style->writeln('(<Space> to pick, <Enter> to continue)');
        $style->newLine();

        return array_column($node[Validator::OPTIONS], 'description');
    }
}
