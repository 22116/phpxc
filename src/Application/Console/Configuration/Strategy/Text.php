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
    private string $error = '';

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
            Validator::REGEXP => 'string',
            Validator::PRE_SCRIPTS => 'array<string|array<string, mixed>>',
            Validator::POST_SCRIPTS => 'array<string|array<string, mixed>>',
            Validator::EXTRA => 'array<mixed>',
        ])] array $node
    ): Generator {
        $style = new IOStyle($this->input, $this->output);

        $style->clear();

        if ($this->error) {
            $style->error($this->error);
        }

        $question = new Question($node[Validator::DESCRIPTION]);
        $text = (string) $style->askQuestion($question);

        if (isset($node[Validator::REGEXP]) && !preg_match('/' . $node[Validator::REGEXP] . '/', $text)) {
            $this->error = sprintf('"%s" regexp is not valid', $node[Validator::REGEXP]);

            yield from $this->read($node);
        } else {
            yield new Configuration\TextNode(
                text: $text,
                description: $node[Validator::DESCRIPTION],
                preScripts: $this->readScripts($node[Validator::PRE_SCRIPTS] ?? []),
                postScripts: $this->readScripts($node[Validator::POST_SCRIPTS] ?? []),
                extra: $node[Validator::EXTRA] ?? [],
            );
        }
    }

    public function supports(string $type): bool
    {
        return Validator::TYPE_TEXT === $type;
    }
}
