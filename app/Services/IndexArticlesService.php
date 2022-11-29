<?php declare(strict_types=1);

namespace App\Services;

use App\Api;
use App\Models\Article;
use App\Models\Collections\ArticlesCollection;

class IndexArticlesService
{
    public function execute(string $query): ArticlesCollection
    {
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
        return new ArticlesCollection($articles);
    }
}
