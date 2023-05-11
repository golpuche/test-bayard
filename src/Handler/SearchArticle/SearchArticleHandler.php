<?php

declare(strict_types=1);

namespace App\Handler\SearchArticle;

use App\Exception\ArticleNotFound;
use App\Helper\FromXML;
use App\Repository\ArticleRepositoryInterface;
use App\ValueObject\Article;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[AsMessageHandler]
final class SearchArticleHandler
{
    use FromXML;

    private const URL_CHILD_NODE_NAME = 'URL';

    public function __construct(private readonly ArticleRepositoryInterface $repository, private readonly SerializerInterface $serializer)
    {
    }

    public function __invoke(SearchArticle $query): Article
    {
        $articles = $this->repository->findAll();

        if (!count($articles)) {
            throw new ArticleNotFound($query->articleId()->url());
        }

        $i = 0;

        do {
            $article = $articles[$i];
            $domDocument = new \DOMDocument();
            $domDocument->loadXML($article->xml());

            /** @var \DOMElement $domElement */
            $domElement = $domDocument->documentElement;

            $nonEmpty = $this->transform($domElement, self::URL_CHILD_NODE_NAME);

            $value = $nonEmpty?->getValue() === $query->articleId()->url() ? $nonEmpty : null;

            ++$i;
        } while (null === $value && $i < count($articles));

        if (null === $value) {
            throw new ArticleNotFound($query->articleId()->url());
        }

        return $this->serializer->deserialize($article->xml(), Article::class, 'xml');
    }
}
