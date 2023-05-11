<?php

namespace ValueObject;

use App\ValueObject\Article;
use PHPUnit\Framework\TestCase;

/** @covers \App\ValueObject\Article */
class ArticleTest extends TestCase
{
    public function test_it_gets_value(): void
    {
        $article = new Article("type", "lundi", "title", "intro", "picture");

        self::assertEquals("type", $article->getType());
        self::assertEquals("title", $article->getTitle());
        self::assertEquals("lundi", $article->getCreationDate());
        self::assertEquals("intro", $article->getIntro());
        self::assertEquals("picture", $article->getPicture());
    }

    public function test_it_returns_null_value_for_empty_properties_intro_and_picture(): void
    {
        $article = new Article("type", "lundi", "title", "", "");

        self::assertNull($article->getIntro());
        self::assertNull($article->getPicture());
    }
}
