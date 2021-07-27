<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Command;

use LSBProject\PHPXC\Domain\Configuration;
use LSBProject\PHPXC\Domain\NodeCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Config extends Command
{
    public function configure(): void
    {
        $this
            ->setName('config')
            ->setDescription('Show configuration tree')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>ROOT</info>');

        $this->printConfiguration($output, Configuration::class);

        return self::SUCCESS;
    }

    /**
     * @param class-string<Configuration\NodeInterface> $node
     */
    private function printConfiguration(OutputInterface $output, string $node, int $level = 0): void
    {
        $prefix = '|    ';
        $nodes = is_subclass_of($node, Configuration\ChoiceNodeInterface::class)
            ? $node::values()
            : [new $node()];

        foreach ($nodes as $item) {
            $name = str_replace(NodeCollection::NAMESPACE_ALIAS, '', $item::class);
            $name = sprintf("<info>%s</info>", $name);
            $line = str_repeat($prefix, $level) . '|-' . $name;

            if ($item instanceof Configuration\ChoiceNodeInterface) {
                $line .= ': ' . $item->getDescription();
            }

            $output->writeln($line);

            if ($item instanceof Configuration\DeepNodeInterface) {
                foreach ($item->getChildren() as $child) {
                    $this->printConfiguration($output, $child, $level + 1);
                }
            }
        }

        $output->writeln(str_repeat($prefix, $level) . '|');
    }
}
