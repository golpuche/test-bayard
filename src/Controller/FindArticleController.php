<?php

namespace App\Controller;

use App\Exception\ArticleNotFound;
use App\Handler\QueryBusInterface;
use App\Handler\SearchArticle\SearchArticle;
use App\Identity\ArticleId;
use App\ValueObject\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FindArticleController extends AbstractController
{
    public function __construct(private readonly QueryBusInterface $queryBus, public readonly SerializerInterface $serializer)
    {
    }

    #[Route('/articles/{url}', name: 'get_article', requirements: ['url' => '^.+'], methods: 'GET')]
    public function getOne(string $url): Response
    {
        try {
            /** @var Article $article */
            $article = $this->queryBus->query(new SearchArticle(ArticleId::fromURL($url)));
        } catch (HandlerFailedException $e) {
            if ($e->getPrevious() instanceof ArticleNotFound) {
                return new JsonResponse(['message' => $e->getPrevious()->getMessage()], Response::HTTP_NOT_FOUND);
            }

            return new JsonResponse(['message' => 'Unexpected error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse($this->serializer->serialize(['data' => $article], 'json'), Response::HTTP_OK, [], true);
    }
}
