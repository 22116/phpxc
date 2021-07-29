<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Configuration;

use JetBrains\PhpStorm\Pure;
use LSBProject\PHPXC\Application\Console\Configuration\Strategy;
use LSBProject\PHPXC\Domain\Configuration\NodeInterface;
use LSBProject\PHPXC\Domain\NodeCollection;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Reader
{
    public function __construct(private InputInterface $input, private OutputInterface $output)
    {
    }

    /**
     * @param mixed[] $configuration
     */
    public function read(array $configuration, string $prefix = ''): NodeCollection
    {
        $prefix = $prefix ? "$prefix." : '';
        $collection = new NodeCollection();

        foreach ($configuration as $key => $item) {
            foreach ($this->getReaders() as $reader) {
                if ($reader->supports($item['type'] ?? '')) {
                    $nodes = $reader->read($item);

                    /** @var NodeInterface $node */
                    foreach ($nodes as $node) {
                        $nodeName = $node->getParentName() ? ("." . $node->getParentName()) : '';
                        $nodeKey = $prefix . $key . $nodeName;

                        $collection->set($nodeKey, $node);

                        if (isset($item['options'][$node->getParentName()]['children'])) {
                            $collection = $collection->merge(
                                $this->read(
                                    $item['options'][$node->getParentName()]['children'],
                                    $nodeKey
                                )
                            );
                        }
                    }

                    break;
                }
            }
        }

        return $collection;
    }

    /**
     * @return Strategy\NodeParserStrategyInterface[]
     */
    #[Pure]
    private function getReaders(): array
    {
        return [
            new Strategy\Text($this->input, $this->output),
            new Strategy\Multiple($this->input, $this->output),
            new Strategy\Choice($this->input, $this->output),
        ];
    }
}
