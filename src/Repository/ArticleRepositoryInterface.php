<?php

declare(strict_types=1);

namespace App\Repository;

use App\Document\Article;

interface ArticleRepositoryInterface
{
    public function save(Article $article): void;

    public function findAll(): array;
}
