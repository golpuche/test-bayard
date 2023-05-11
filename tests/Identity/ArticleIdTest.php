<?php

namespace Identity;

use App\Identity\ArticleId;
use PHPUnit\Framework\TestCase;

/** @covers \App\Identity\ArticleId */
class ArticleIdTest extends TestCase
{
    public function test_it_gets_url(): void
    {
        $articleId = ArticleId::fromURL("test");

        self::assertEquals("/test", $articleId->url());
    }}
