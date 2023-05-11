<?php

declare(strict_types=1);

namespace App\Repository;

use App\Document\Article;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;

final class ArticleRepository implements ArticleRepositoryInterface
{
    private DocumentManager $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * @throws MongoDBException
     */
    public function save(Article $article): void
    {
        $this->documentManager->persist($article);
        $this->documentManager->flush();
    }

    /** @return Article[] */
    public function findAll(): array
    {
        return $this->documentManager->getRepository(Article::class)->findAll();
    }
}
