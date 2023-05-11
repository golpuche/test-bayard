<?php

namespace Handler\SearchArticle;

use App\Document\Article;
use App\Exception\ArticleNotFound;
use App\Identity\ArticleId;
use App\Handler\SearchArticle\SearchArticle;
use App\Handler\SearchArticle\SearchArticleHandler;
use App\Repository\ArticleRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

/** @covers \App\Handler\SearchArticle\SearchArticleHandler */
class SearchArticleHandlerTest extends TestCase
{
    /** @var MockObject */
    private $repository;

    /** @var SerializerInterface */
    private $serializer;

    private $xml1 = '<Article id="a5147990-9191-4fdf-968b-6ae5f562cef3">
        <CreationDate>2020-05-19T13:17:11+02:00</CreationDate>
        <Type>standard</Type>
        <Title>Article1</Title>
        <URL>/France/Article1</URL>
        <Intro/>
        <Picture/>
    </Article>';

    private $xml2 = '<Article id="a5147990-9191-4fdf-968b-6ae5f562cef3">
        <CreationDate>2020-05-19T13:17:11+02:00</CreationDate>
        <Type>standard</Type>
        <Title>Article1</Title>
        <URL>/France/Article2</URL>
        <Intro/>
        <Picture/>
    </Article>';

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getMockBuilder(ArticleRepositoryInterface::class)->getMock();
        $this->serializer = $this->getMockBuilder(SerializerInterface::class)->getMock();

    }

    public function test_invoke_will_throw_not_found_exception_when_there_is_any_articles()
    {
        $this->repository->expects($this->once())->method("findAll")->willReturn([]);
        $this->expectExceptionObject(new ArticleNotFound("/test"));

        $handler = new SearchArticleHandler($this->repository, $this->serializer);

        $handler(new SearchArticle(ArticleId::fromURL("test")));
    }

    public function test_invoke_will_throw_not_found_exception_when_there_is_no_article_matching_the_url()
    {
        $article = new Article();
        $article->setId("ID-1");
        $article->setXml($this->xml1);

        $this->repository->expects($this->once())->method("findAll")->willReturn([$article]);
        $this->expectExceptionObject(new ArticleNotFound("/test"));

        $handler = new SearchArticleHandler($this->repository, $this->serializer);

        $handler(new SearchArticle(ArticleId::fromURL("test")));
    }

    public function test_invoke_will_returns_article_based_on_url()
    {
        $article1 = new Article();
        $article1->setId("ID-1");
        $article1->setXml($this->xml1);

        $article2 = new Article();
        $article2->setId("ID-2");
        $article2->setXml($this->xml2);


        $this->repository->expects($this->once())->method("findAll")->willReturn([$article1, $article2]);
        $this->serializer
            ->expects($this->once())
            ->method("deserialize")
            ->with($this->xml1, \App\ValueObject\Article::class, "xml")
            ->willReturn(new \App\ValueObject\Article("standard", "2020-05-19T13:17:11+02:00", "Article1", "", ""));

        $handler = new SearchArticleHandler($this->repository, $this->serializer);

        $found = $handler(new SearchArticle(ArticleId::fromURL("France/Article1")));

        $this->assertEquals("standard", $found->getType());
        $this->assertEquals("2020-05-19T13:17:11+02:00", $found->getCreationDate());
        $this->assertEquals("Article1", $found->getTitle());
        $this->assertNull($found->getPicture());
        $this->assertNull($found->getIntro());
    }
}
