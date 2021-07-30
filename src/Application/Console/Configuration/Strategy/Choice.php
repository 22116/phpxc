<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Configuration\Strategy;

use BlueConsole\MultiSelect;
use Generator;
use JetBrains\PhpStorm\ArrayShape;
use LSBProject\PHPXC\Application\Console\Configuration\Validator;
use LSBProject\PHPXC\Application\Console\IOStyle;
use LSBProject\PHPXC\Domain\Configuration;

final class Choice extends AbstractChoice
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
        $choices = $this->buildQuestion($node, 'Choose single option:');
        $style = new IOStyle($this->input, $this->output);
        $multiselect = new MultiSelect($style);
        $selected = $multiselect->renderSingleSelect($choices);

        $option = array_values($node[Validator::OPTIONS])[$selected ?: 0];

        yield new Configuration\Node(
            description: $option[Validator::DESCRIPTION],
            preScripts: $this->readScripts($option[Validator::PRE_SCRIPTS] ?? []),
            postScripts: $this->readScripts($option[Validator::POST_SCRIPTS] ?? []),
            parentName: (string) array_keys($node[Validator::OPTIONS])[$selected],
        );
    }

    public function supports(string $type): bool
    {
        return Validator::TYPE_CHOICE === $type;
    }
}
