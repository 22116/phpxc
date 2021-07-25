<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Console\ConfigurationReader\Strategy;

use Generator;
use LSBProject\PHPXC\Configuration\TextNodeInterface;
use ReflectionClass;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

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
        $style = new SymfonyStyle($this->input, $this->output);
        $style->write(sprintf("\033\143"));

        /** @var TextNodeInterface $option */
        $option = new $node();
        $question = new Question($option::getTitle());

        $option->setText((string) $style->askQuestion($question));

        yield $option;

        $style->write(sprintf("\033\143"));
    }

    public function supports(string $node): bool
    {
        return (new ReflectionClass($node))->implementsInterface(TextNodeInterface::class);
    }
}
