<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Configuration;

use Exception;
use JetBrains\PhpStorm\Pure;
use LSBProject\PHPXC\Application\Console\Configuration\Strategy;
use LSBProject\PHPXC\Domain\Configuration;
use LSBProject\PHPXC\Domain\Configuration\Node;
use LSBProject\PHPXC\Domain\Configuration\NodeCollection;
use LSBProject\PHPXC\Domain\Configuration\NodeInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Reader
{
    public function __construct(private InputInterface $input, private OutputInterface $output)
    {
    }

    /**
     * @param mixed[] $configuration
     *
     * @throws Exception
     */
    public function read(array $configuration): Configuration
    {
        return new Configuration(
            nodes: $this->readNodes($configuration[Validator::NODES]),
            removeEmptyDirectories: (bool) ($configuration[Validator::REMOVE_EMPTY_DIRECTORIES] ?? false),
            directoryIgnoreList:
                $configuration[Validator::REMOVE_EMPTY_DIRECTORIES][Validator::REMOVE_EMPTY_DIRECTORIES_IGNORE_LIST]
                    ?? [],
        );
    }

    /**
     * @param mixed[] $configuration
     *
     * @throws Exception
     */
    public function readNodes(array $configuration, string $prefix = ''): NodeCollection
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

                        if ($node->getParentName()) {
                            $collection->set($prefix . $key . $nodeName, new Node(
                                description: $node->getDescription(),
                                extra: $node->getExtra(),
                            ));
                        }

                        $collection->set($prefix . $key, $node);

                        if (isset($item['options'][$node->getParentName()]['children'])) {
                            $collection = $collection->merge(
                                $this->readNodes(
                                    $item['options'][$node->getParentName()]['children'],
                                    $prefix . $key . $nodeName
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
            new Strategy\Multiple(),
            new Strategy\Choice(),
        ];
    }
}
