<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Configuration\Strategy;

use Generator;
use JetBrains\PhpStorm\ArrayShape;
use LSBProject\PHPXC\Application\Console\Configuration\Validator;
use LSBProject\PHPXC\Domain\Configuration;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use PhpSchool\CliMenu\Exception\InvalidTerminalException;

final class Multiple extends AbstractNodeParser
{
    /**
     * {@inheritdoc}
     *
     * @param mixed[] $node
     *
     * @throws InvalidTerminalException
     */
    public function read(
        #[ArrayShape([
            Validator::DESCRIPTION => 'string',
            Validator::OPTIONS => 'array<string, string>',
        ])] array $node
    ): Generator {
        $menuBuilder = new CliMenuBuilder();
        $menuBuilder
            ->setExitButtonText('Confirm')
            ->setTitle($node[Validator::DESCRIPTION])
            ->setForegroundColour('green')
            ->setBackgroundColour('black')
        ;

        $selected = [];

        foreach ($node[Validator::OPTIONS] as $key => $option) {
            $menuBuilder->addCheckboxItem(
                $option[Validator::DESCRIPTION],
                static function () use ($key, &$selected): void {
                    if (isset($selected[$key])) {
                        unset($selected[$key]);
                    } else {
                        $selected[$key] = $key;
                    }
                }
            );
        }

        $menuBuilder
            ->addLineBreak('-')
            ->build()
            ->open();

        foreach ($selected as $item) {
            $option = $node[Validator::OPTIONS][$item];

            yield new Configuration\Node(
                description: $option[Validator::DESCRIPTION],
                preScripts: $this->readScripts($option[Validator::PRE_SCRIPTS] ?? []),
                postScripts: $this->readScripts($option[Validator::POST_SCRIPTS] ?? []),
                parentName: $item,
                extra: $option[Validator::EXTRA] ?? [],
            );
        }
    }

    public function supports(string $type): bool
    {
        return Validator::TYPE_MULTIPLE === $type;
    }
}
