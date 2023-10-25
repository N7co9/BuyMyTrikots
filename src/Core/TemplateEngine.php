<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
class TemplateEngine implements TemplateInterface
{
    private Environment $twig;
    private string $tpl;

    public string $templatePath;
    public array $parameters;
    public function __construct($templatePath)
    {
        $this->templatePath = $templatePath;
        $loader = new FilesystemLoader($this->templatePath);
        $this->twig = new Environment($loader);
    }

    public function addParameter(string $key, mixed $value): void
    {
        $this->parameters[$key] = $value;
    }

    public function display()
    {
        echo $this->twig->render($this->tpl, $this->parameters);
    }

    public function setTemplate(string $tpl)
    {
        $this->tpl = $tpl;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getTpl(): string
    {
        return $this->tpl;
    }
}