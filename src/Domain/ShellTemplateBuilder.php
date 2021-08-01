<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Domain;

use LSBProject\PHPXC\Domain\Configuration\NodeCollection;
use LSBProject\PHPXC\Domain\Configuration\NodeInterface;
use LSBProject\PHPXC\Domain\Configuration\Script;
use LSBProject\PHPXC\Domain\Contract\ShellExecutorInterface;

final class ShellTemplateBuilder implements TemplateBuilderInterface
{
    private const PATH_VARIABLE = '{PATH}';

    public function __construct(private TemplateBuilder $templateBuilder, private ShellExecutorInterface $executor)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function build(Configuration $configuration, string $path, string $templatePath): void
    {
        $this->executeScripts($configuration->getNodes(), $path);
        $this->templateBuilder->build($configuration, $path, $templatePath);
        chdir($path);
        $this->executeScripts($configuration->getNodes(), $path, true);
    }

    private function executeScripts(NodeCollection $collection, string $path, bool $post = false): void
    {
        /** @var NodeInterface $node */
        foreach ($collection as $node) {
            $scripts = $post ? $node->getPostScripts() : $node->getPreScripts();

            foreach ($scripts as $script) {
                if ($this->isScriptAllowed($collection, $script)) {
                    $this->executor->execute(
                        str_replace(self::PATH_VARIABLE, $path, $script->getCommand())
                    );
                }
            }
        }
    }

    private function isScriptAllowed(NodeCollection $collection, Script $script): bool
    {
        foreach ($script->getIncludes() as $include) {
            if (!$collection->has($include)) {
                return false;
            }
        }

        foreach ($script->getExcludes() as $exclude) {
            if ($collection->has($exclude)) {
                return false;
            }
        }

        return true;
    }
}
