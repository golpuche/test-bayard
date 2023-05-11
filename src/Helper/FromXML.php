<?php

declare(strict_types=1);

namespace App\Helper;

use App\ValueObject\NonEmpty;
use Webmozart\Assert\Assert;

trait FromXML
{
    final public function childToNonEmpty(\DOMElement $root, string $name, string $type = NonEmpty::class): ?NonEmpty
    {
        if (null === $value = $this->childValue($root, $name)) {
            return null;
        }

        return $this->toNonEmpty($value, $type);
    }

    final public function toNonEmpty(string $value, string $type = NonEmpty::class): NonEmpty
    {
        $isValid = is_a($type, NonEmpty::class, true);
        Assert::true($isValid, 'INVALID TYPE');

        return new NonEmpty($value);
    }

    final public function transform(\DOMElement $root, string $name, string $type = NonEmpty::class): ?NonEmpty
    {
        return $this->childToNonEmpty($root, $name, $type);
    }

    private function childValue(\DOMElement $root, string $name): ?string
    {
        [$domElement] = $root->getElementsByTagName($name);

        return $domElement?->nodeValue;
    }
}
