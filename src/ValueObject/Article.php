<?php

declare(strict_types=1);

namespace App\ValueObject;

final class Article
{
    private string $type;

    private string|null $title;

    private string $creationDate;

    private string|null $intro;

    private string|null $picture;

    public function __construct(
        string $Type,
        string $CreationDate,
        string $Title,
        string|null $Intro = null,
        string|null $Picture = null
    ) {
        $this->type = $Type;
        $this->creationDate = $CreationDate;
        $this->title = $Title;
        $this->intro = '' === $Intro ? null : $Intro;
        $this->picture = '' === $Picture ? null : $Picture;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    public function getIntro(): string|null
    {
        return $this->intro;
    }

    public function getPicture(): string|null
    {
        return $this->picture;
    }
}
