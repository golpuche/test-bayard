<?php

declare(strict_types=1);

namespace App\ValueObject;

final class NonEmpty
{
    public function __construct(private readonly string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
