<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Configuration\Strategy;

use Generator;
use JetBrains\PhpStorm\ArrayShape;
use LSBProject\PHPXC\Application\Console\Configuration\Validator;
use LSBProject\PHPXC\Domain\Configuration;
use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\Exception\InvalidTerminalException;

final class Choice extends AbstractNodeParser
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
            ->disableDefaultItems()
        ;

        $selected = 0;

        foreach ($node[Validator::OPTIONS] as $key => $option) {
            $menuBuilder->addRadioItem(
                $option[Validator::DESCRIPTION],
                static function (CliMenu $menu) use ($key, &$selected) {
                    $selected = $key;

                    $menu->close();
                }
            );
        }

        $menuBuilder
            ->build()
            ->open();

        $option = $node[Validator::OPTIONS][$selected];

        yield new Configuration\Node(
            description: $option[Validator::DESCRIPTION],
            preScripts: $this->readScripts($option[Validator::PRE_SCRIPTS] ?? []),
            postScripts: $this->readScripts($option[Validator::POST_SCRIPTS] ?? []),
            parentName: $selected,
            extra: $option[Validator::EXTRA] ?? [],
        );
    }

    public function supports(string $type): bool
    {
        return Validator::TYPE_CHOICE === $type;
    }
}
