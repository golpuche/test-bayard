<?php

namespace Repository;

use App\Document\Article;
use App\Repository\ArticleRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
use PHPUnit\Framework\TestCase;

/** @covers \App\Repository\ArticleRepository */
class ArticleRepositoryTest extends TestCase
{
    public function test_it_save()
    {
        $article = new Article();

        $documentManager = $this->getMockBuilder(DocumentManager::class)->disableOriginalConstructor()->getMock();
        $documentManager->expects($this->once())->method("persist")->with($article);
        $documentManager->expects($this->once())->method("flush")->with();

        $repository = new ArticleRepository($documentManager);
        $repository->save($article);
    }

    public function test_find_all()
    {
        $article = new Article();

        $documentManager = $this->getMockBuilder(DocumentManager::class)->disableOriginalConstructor()->getMock();

        $documentRepository = $this->getMockBuilder(DocumentRepository::class)->disableOriginalConstructor()->getMock();
        $documentRepository->expects($this->once())->method("findAll")->willReturn([$article]);

        $documentManager->expects($this->once())->method("getRepository")->with(Article::class)->willReturn($documentRepository);

        $repository = new ArticleRepository($documentManager);
        self::assertEquals([$article], $repository->findAll());
    }
}