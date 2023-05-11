<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;

/** @Document(collection="article") */
class Article
{
    /** @Id(strategy="uuid") */
    private string $id;

    /** @Field(type="string") */
    private string $xml;

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setXml(string $xml): void
    {
        $this->xml = $xml;
    }

    public function xml(): string
    {
        return $this->xml;
    }
}
