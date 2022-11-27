<?php declare(strict_types=1);

namespace App;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Template
{
    private string $path;
    private array $data;
    private string $viewsBasePath = "views";

    public function __construct(string $path, array $data = [])
    {
        $this->path = $path;
        $this->data = $data;
    }

    public function render(): string
    {
        $loader = new FilesystemLoader($this->viewsBasePath);
        $twig = new Environment($loader);
        return $twig->render($this->path, $this->data);
    }
}
