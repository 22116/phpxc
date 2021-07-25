<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Console\ConfigurationReader\Strategy;

use BlueConsole\MultiSelect;
use Generator;
use LSBProject\PHPXC\Configuration\MultiChoiceNodeInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Console\Style\SymfonyStyle;

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

        $style = new SymfonyStyle($this->input, $this->output);
        $multiselect = new MultiSelect($style);
        $selected = $multiselect->renderMultiSelect($choices);

        $options = $this->invokeStaticMethod($node, 'values');

        foreach ($selected as $item) {
            yield array_values($options)[$item];
        }

        $style->write(sprintf("\033\143"));
    }

    public function supports(string $node): bool
    {
        return (new ReflectionClass($node))->implementsInterface(MultiChoiceNodeInterface::class);
    }
}
