<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Application\Console\Configuration;

use Exception;
use InvalidArgumentException;

class Validator
{
    public const ROOT_NODE = 'nodes';

    public const TYPE = 'type';
    public const TYPE_TEXT = 'text';
    public const TYPE_CHOICE = 'choice';
    public const TYPE_MULTIPLE = 'multiple';

    public const DESCRIPTION = 'description';
    public const CHILDREN = 'children';
    public const OPTIONS = 'options';
    public const EXTRA = 'extra';

    public const SCRIPT = 'script';
    public const PRE_SCRIPTS = 'preScripts';
    public const POST_SCRIPTS = 'postScripts';

    public const SCRIPTS_INCLUDES = 'includes';
    public const SCRIPTS_EXCLUDES = 'excludes';

    public const TYPES = [self::TYPE_CHOICE, self::TYPE_MULTIPLE, self::TYPE_TEXT];

    /**
     * @param mixed[] $configuration
     *
     * @throws Exception
     */
    public function validate(array $configuration): void
    {
        foreach ($configuration as $key => $item) {
            if (!isset($item[self::DESCRIPTION]) || !is_string($item[self::DESCRIPTION])) {
                throw new InvalidArgumentException(
                    sprintf('"%s.%s" must be with type "string"', $key, self::DESCRIPTION)
                );
            }

            if (!isset($item[self::TYPE]) || !in_array($item[self::TYPE], self::TYPES, true)) {
                throw new InvalidArgumentException(
                    sprintf(
                        '"%s.%s" must contains one of the next values: %s',
                        $key,
                        self::TYPE,
                        implode(', ', self::TYPES)
                    )
                );
            }

            if (isset($item[self::PRE_SCRIPTS])) {
                $this->validateScripts($item, $key, self::PRE_SCRIPTS);
            }

            if (isset($item[self::POST_SCRIPTS])) {
                $this->validateScripts($item, $key, self::POST_SCRIPTS);
            }

            if (in_array($item[self::TYPE], [self::TYPE_CHOICE, self::TYPE_MULTIPLE], true)) {
                if ((!isset($item[self::OPTIONS]) || !is_array($item[self::OPTIONS]))) {
                    throw new InvalidArgumentException(
                        sprintf('"%s.%s" must be with type "array"', $key, self::OPTIONS)
                    );
                }

                foreach ($item[self::OPTIONS] as $option) {
                    if (!isset($option[self::DESCRIPTION]) || !is_string($option[self::DESCRIPTION])) {
                        throw new InvalidArgumentException(
                            sprintf('"%s.%s" must be with type "string"', $key, self::DESCRIPTION)
                        );
                    }

                    if (isset($option[self::CHILDREN])) {
                        self::validate($option[self::CHILDREN]);
                    }
                }
            }

            if (isset($item[self::CHILDREN])) {
                self::validate($item[self::CHILDREN]);
            }
        }
    }

    /**
     * @param mixed[] $scripts
     */
    private function validateScripts(array $scripts, string $key, string $name): void
    {
        foreach ($scripts as $script) {
            if (!(is_string($script) || is_array($script))) {
                throw new InvalidArgumentException(
                    sprintf('"%s.%s" must be with type "string" or "array"', $key, $name)
                );
            }

            if (is_array($script) && (!isset($script[self::SCRIPT]) || !is_string($script[self::SCRIPT]))) {
                throw new InvalidArgumentException(
                    sprintf('"%s.%s.%s" must be with type "string"', $key, $name, self::SCRIPT)
                );
            }
        }
    }
}
