<?php

declare(strict_types=1);

namespace LSBProject\PHPXC\Infrastructure;

use LSBProject\PHPXC\Constant;
use LSBProject\PHPXC\Domain\Contract\TemplateEngineInterface;
use LSBProject\PHPXC\Domain\Exception\FilesystemException;
use RuntimeException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class TwigTemplateEngine implements TemplateEngineInterface
{
    private Environment $twig;

    public function __construct()
    {
        $this->twig = new Environment(new FilesystemLoader(Constant::TEMPLATES_PATH));
    }

    public function loadTemplates(string $path): void
    {
        $this->twig = new Environment(new FilesystemLoader($path));
    }

    /**
     * {@inheritdoc}
     */
    public function render(string $template, array $data): string
    {
        try {
            return $this->twig->createTemplate($template)->render($data);
        } catch (SyntaxError | LoaderError $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function renderFile(string $path, array $data): string
    {
        try {
            return $this->twig->render($path, $data);
        } catch (RuntimeError | SyntaxError $exception) {
            throw new RuntimeException($exception->getMessage());
        } catch (LoaderError $exception) {
            throw new FilesystemException($exception->getMessage());
        }
    }
}
