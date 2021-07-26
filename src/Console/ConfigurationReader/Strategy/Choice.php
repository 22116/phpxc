<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Console\ConfigurationReader\Strategy;

use BlueConsole\MultiSelect;
use Generator;
use LSBProject\PHPXC\Configuration\ChoiceNodeInterface;
use LSBProject\PHPXC\Console\IOStyle;
use ReflectionClass;
use ReflectionException;

final class Choice extends AbstractCheckbox
{
    /**
     * {@inheritdoc}
     *
     * @param class-string<ChoiceNodeInterface> $node
     *
     * @throws ReflectionException
     */
    public function read(string $node): Generator
    {
        $choices = $this->buildQuestion($node, 'Choose single option:');

        $style = new IOStyle($this->input, $this->output);
        $multiselect = new MultiSelect($style);
        $selected = $multiselect->renderSingleSelect($choices);

        $options = $this->invokeStaticMethod($node, 'values');

        yield array_values($options)[$selected];
    }

    public function supports(string $node): bool
    {
        return (new ReflectionClass($node))->implementsInterface(ChoiceNodeInterface::class);
    }
}
