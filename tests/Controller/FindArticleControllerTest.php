<?php

namespace Controller;

use App\Controller\FindArticleController;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/** @covers \App\Controller\FindArticleController */
class FindArticleControllerTest extends WebTestCase
{
    public function test_it_does_not_found_article(): void
    {
        $client = static::createClient();

        $client->request('GET', '/articles/url');

        $this->assertSame(404, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $this->assertEquals(["message" => "Aucun article n'a été trouvé pour cette url {{ </url> }}"], json_decode($client->getResponse()->getContent(), true));
    }

    public function test_it_found_an_article(): void
    {
        $client = static::createClient();

        $client->request('GET', '/articles/France/Article1');

        $this->assertResponseIsSuccessful();

        $this->assertJson($client->getResponse()->getContent());
        $this->assertEquals(["data" => [
            "title" => "Article1",
            "type" => "standard",
            "creationDate" => "2020-05-19T13:17:11+02:00",
            "intro" => null,
            "picture" => null
        ]], json_decode($client->getResponse()->getContent(), true));
    }
}
