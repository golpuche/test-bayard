<?php

namespace ValueObject;

use App\ValueObject\NonEmpty;
use PHPUnit\Framework\TestCase;

/** @covers \App\ValueObject\NonEmpty */
class NonEmptyTest extends TestCase
{
    public function test_it_gets_value(): void
    {
        $nonEmpty = new NonEmpty("foo");

        self::assertEquals("foo", $nonEmpty->getValue());
    }
}
