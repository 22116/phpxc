<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Console\ConfigurationReader\Strategy;

use LSBProject\PHPXC\Configuration\NodeInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class AbstractCheckbox implements NodeParserStrategyInterface
{
    public function __construct(protected InputInterface $input, protected OutputInterface $output)
    {
    }

    /**
     * @param class-string<NodeInterface> $nodeClass
     *
     * @throws ReflectionException
     *
     * @return string[]
     */
    protected function buildQuestion(string $nodeClass, string $question): array
    {
        $options = $this->invokeStaticMethod($nodeClass, 'values');
        $title = $this->invokeStaticMethod($nodeClass, 'getTitle');

        $style = new SymfonyStyle($this->input, $this->output);
        $style->write(sprintf("\033\143"));
        $style->writeln($title);
        $style->writeln($question);
        $style->writeln('(<Space> to pick, <Enter> to continue)');
        $style->newLine();

        $choices = array_map(static fn(NodeInterface $node) => $node->getDescription(), $options);

        return array_values($choices);
    }

    /**
     * @param class-string<NodeInterface> $nodeClass
     *
     * @throws ReflectionException
     */
    protected function invokeStaticMethod(string $nodeClass, string $method): mixed
    {
        $reflector = new ReflectionClass($nodeClass);

        return $reflector->getMethod($method)->invoke(null);
    }
}