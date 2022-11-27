<?php declare(strict_types=1);

namespace App\Controllers;

use App\Api;
use App\Models\Article;
use App\Template;


class NewsController
{
    public function index(): Template
    {
        $query = $_GET["search"] ?? "Latvia";
        $pageSize = 20;
        $allArticles = (new Api())->newsApi()->getEverything($query,null,null,null,null,null,null,null,$pageSize);
        $articles = [];
        foreach ($allArticles->articles as $article) {
            $articles[] = new Article(
                $article->title,
                $article->url,
                $article->urlToImage,
                strip_tags($article->description)
            );
        }
        return new Template('index.html.twig', ['articles' => $articles]);
    }
}
