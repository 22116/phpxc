<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Console\ConfigurationReader\Strategy;

use BlueConsole\MultiSelect;
use Generator;
use LSBProject\PHPXC\Configuration\ChoiceNodeInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Console\Style\SymfonyStyle;

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

        $style = new SymfonyStyle($this->input, $this->output);
        $multiselect = new MultiSelect($style);
        $selected = $multiselect->renderSingleSelect($choices);

        $options = $this->invokeStaticMethod($node, 'values');

        yield array_values($options)[$selected];

        $style->write(sprintf("\033\143"));
    }

    public function supports(string $node): bool
    {
        return (new ReflectionClass($node))->implementsInterface(ChoiceNodeInterface::class);
    }
}
