<?php

namespace App\Identity;

class ArticleId
{
    private string $url;

    public static function fromURL(
        string $url
    ): self {
        $self = new self();

        $self->url = "/$url";

        return $self;
    }

    public function url(): string
    {
        return $this->url;
    }
}
