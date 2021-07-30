<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Configuration\Strategy;

use Generator;
use JetBrains\PhpStorm\ArrayShape;
use LSBProject\PHPXC\Application\Console\Configuration\Validator;
use LSBProject\PHPXC\Application\Console\IOStyle;
use LSBProject\PHPXC\Domain\Configuration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

final class Text extends AbstractNodeParser
{
    public function __construct(private InputInterface $input, private OutputInterface $output)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed[] $node
     */
    public function read(
        #[ArrayShape([
            Validator::DESCRIPTION => 'string',
            Validator::TYPE_TEXT => 'string',
        ])] array $node
    ): Generator {
        $style = new IOStyle($this->input, $this->output);

        $style->clear();

        $question = new Question($node[Validator::DESCRIPTION]);

        yield new Configuration\TextNode(
            text: (string) $style->askQuestion($question),
            preScripts: $this->readScripts($node[Validator::PRE_SCRIPTS] ?? []),
            postScripts: $this->readScripts($node[Validator::POST_SCRIPTS] ?? []),
            description: $node[Validator::DESCRIPTION],
        );
    }

    public function supports(string $type): bool
    {
        return Validator::TYPE_TEXT === $type;
    }
}
