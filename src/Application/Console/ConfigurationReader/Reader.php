<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\ConfigurationReader;

use LSBProject\PHPXC\Application\Console\ConfigurationReader\Strategy;
use LSBProject\PHPXC\Domain\Configuration;
use LSBProject\PHPXC\Domain\NodeCollection;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Reader
{
    public function __construct(private InputInterface $input, private OutputInterface $output)
    {
    }

    /**
     * @param class-string<Configuration\NodeInterface> $configuration
     */
    public function read(string $configuration): NodeCollection
    {
        $nodes = new NodeCollection();

        foreach ($this->getReaders() as $reader) {
            if ($reader->supports($configuration)) {
                /** @var Configuration\NodeInterface $node */
                foreach ($reader->read($configuration) as $node) {
                    $nodes->add($node);

                    if ($node instanceof Configuration\DeepNodeInterface) {
                        foreach ($node->getChildren() as $child) {
                            $nodes = $nodes->merge($this->read($child));
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
            new Strategy\Text($this->input, $this->output),
            new Strategy\Checkbox($this->input, $this->output),
            new Strategy\Choice($this->input, $this->output),
            new Strategy\Aggregator(),
        ];
    }
}
