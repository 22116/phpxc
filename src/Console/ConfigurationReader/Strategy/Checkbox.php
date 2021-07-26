<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Console\ConfigurationReader\Strategy;

use BlueConsole\MultiSelect;
use Generator;
use LSBProject\PHPXC\Configuration\MultiChoiceNodeInterface;
use LSBProject\PHPXC\Console\IOStyle;
use ReflectionClass;
use ReflectionException;

final class Checkbox extends AbstractCheckbox
{
    /**
     * {@inheritdoc}
     *
     * @param class-string<MultiChoiceNodeInterface> $node
     *
     * @throws ReflectionException
     */
    public function read(string $node): Generator
    {
        $choices = $this->buildQuestion($node, 'Choose several options:');

        $style = new IOStyle($this->input, $this->output);
        $multiselect = new MultiSelect($style);
        $selected = $multiselect->renderMultiSelect($choices);

        $options = $this->invokeStaticMethod($node, 'values');

        foreach ($selected as $item) {
            yield array_values($options)[$item];
        }
    }

    public function supports(string $node): bool
    {
        return (new ReflectionClass($node))->implementsInterface(MultiChoiceNodeInterface::class);
    }
}
