<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\ConfigurationReader\Strategy;

use Generator;
use LSBProject\PHPXC\Application\Console\IOStyle;
use LSBProject\PHPXC\Domain\Configuration\TextNodeInterface;
use ReflectionClass;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

final class Text implements NodeParserStrategyInterface
{
    public function __construct(private InputInterface $input, private OutputInterface $output)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function read(string $node): Generator
    {
        $style = new IOStyle($this->input, $this->output);

        $style->clear();

        /** @var TextNodeInterface $option */
        $option = new $node();
        $question = new Question($option::getTitle());

        $option->setText((string) $style->askQuestion($question));

        yield $option;
    }

    public function supports(string $node): bool
    {
        return (new ReflectionClass($node))->implementsInterface(TextNodeInterface::class);
    }
}