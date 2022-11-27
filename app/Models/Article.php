<?php declare(strict_types=1);

namespace App\Models;

class Article
{
    private string $title;
    private string $url;
    private string $image;
    private string $description;

    public function __construct(string $title, string $url, string $image, string $description)
    {
        $this->title = $title;
        $this->url = $url;
        $this->image = $image;
        $this->description = $description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
