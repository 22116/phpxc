<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Console\ConfigurationReader;

use LSBProject\PHPXC\Configuration;
use LSBProject\PHPXC\Console\ConfigurationReader\Strategy;
use LSBProject\PHPXC\NodeCollection;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Reader
{
    public function __construct(private InputInterface $input, private OutputInterface $output)
    {
    }

    public function read(Configuration $configuration): NodeCollection
    {
        $nodes = new NodeCollection();

        foreach ($configuration->getChildren() as $nodeClass) {
            $nodes = $nodes->merge($this->performReaders($nodeClass));
        }

        return $nodes;
    }

    /**
     * @param class-string<Configuration\NodeInterface> $nodeClass
     */
    private function performReaders(string $nodeClass): NodeCollection
    {
        $nodes = new NodeCollection();

        foreach ($this->getReaders() as $reader) {
            if ($reader->supports($nodeClass)) {
                /** @var Configuration\NodeInterface $node */
                foreach ($reader->read($nodeClass) as $node) {
                    $nodes->add($node);

                    if ($node instanceof Configuration\DeepNodeInterface) {
                        foreach ($node->getChildren() as $child) {
                            $nodes = $nodes->merge($this->performReaders($child));
                        }
                    }
                }

                break;
            }
        }

        return $nodes;
    }

    /**
     * @return Strategy\NodeParserStrategyInterface[]
     */
    private function getReaders(): array
    {
        return [
            new Strategy\Checkbox($this->input, $this->output),
            new Strategy\Choice($this->input, $this->output),
        ];
    }
}
