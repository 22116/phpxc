<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Configuration\Strategy;

use BlueConsole\MultiSelect;
use Generator;
use JetBrains\PhpStorm\ArrayShape;
use LSBProject\PHPXC\Application\Console\Configuration\Validator;
use LSBProject\PHPXC\Application\Console\IOStyle;
use LSBProject\PHPXC\Domain\Configuration;

final class Multiple extends AbstractChoice
{
    /**
     * {@inheritdoc}
     *
     * @param mixed[] $node
     */
    public function read(
        #[ArrayShape([
            Validator::DESCRIPTION => 'string',
            Validator::OPTIONS => 'array<string, string>',
        ])] array $node
    ): Generator {
        $choices = $this->buildQuestion($node, 'Choose several options:');
        $style = new IOStyle($this->input, $this->output);
        $multiselect = new MultiSelect($style);
        $selected = $multiselect->renderMultiSelect($choices);

        foreach ($selected as $item) {
            $option = array_values($node[Validator::OPTIONS])[$item];

            yield new Configuration\Node(
                description: $option[Validator::DESCRIPTION],
                preScripts: $this->readScripts($option[Validator::PRE_SCRIPTS] ?? []),
                postScripts: $this->readScripts($option[Validator::POST_SCRIPTS] ?? []),
                parentName: (string) array_keys($node[Validator::OPTIONS])[$item],
            );
        }
    }

    public function supports(string $type): bool
    {
        return Validator::TYPE_MULTIPLE === $type;
    }
}
