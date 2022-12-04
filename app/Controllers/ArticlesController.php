<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\IndexArticlesService;
use App\Template;


class ArticlesController
{
    public function index(): Template
    {
        $query = $_GET["search"] ?? "Latvia";
        $articles = (new IndexArticlesService())->execute($query);
        return new Template('articles.twig', ['articles' => $articles->get()]);
    }
}
