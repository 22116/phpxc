<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Console\ConfigurationReader\Strategy;

use BlueConsole\MultiSelect;
use Generator;
use LSBProject\PHPXC\Configuration\NodeInterface;
use ReflectionClass;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class Choice implements NodeParserStrategyInterface
{
    public function __construct(private InputInterface $input, private OutputInterface $output)
    {
    }

    public function read(string $node): Generator
    {
        $method = 'values';
        $options = $node::$method();

        $style = new SymfonyStyle($this->input, $this->output);
        $style->write(sprintf("\033\143"));
        $style->writeln('Choose one option:');
        $style->writeln('(<Space> to pick, <Enter> to continue)');
        $style->newLine();

        $choices = array_map(static fn(NodeInterface $node) => $node->getDescription(), $options);
        $choices = array_values($choices);

        $multiselect = new MultiSelect($style);
        $selected = $multiselect->renderSingleSelect($choices);

        yield array_values($options)[$selected];

        $style->write(sprintf("\033\143"));
    }

    public function supports(string $node): bool
    {
        return (new ReflectionClass($node))->implementsInterface(NodeInterface::class);
    }
}
