<?php

declare(strict_types=1);

namespace App\Handler\SearchArticle;

use App\Identity\ArticleId;

final class SearchArticle
{
    public function __construct(private readonly ArticleId $articleId)
    {
    }

    public function articleId(): ArticleId
    {
        return $this->articleId;
    }
}
