# TEST

L'objet Article est sauvegardé dans la base de donnée nosql sous la forme d'un xml : article1.xml

```xml

<Article id="a5147990-9191-4fdf-968b-6ae5f562cef3">
    <CreationDate>2020-05-19T13:17:1 1+02:00</CreationDate>
    <Type>standard</Type>
    <Title>Article1</Title>
    <URL>/France/Article1</URL>
    <Intro/>
    <Picture/>
</Article>
```

1. Créer un ValueObject **Article**
2. Créer une Entité **Article**
3. Créer un trait **FromXML** avec une fonction **transform**, qui permet de récupérer la valeur du noeud **URL** du
   xml de l'article à l'aide de ces fonctions (compléter le return de la fonction **toNonEmpty**)

```php
/**
 * Tries to return child node text value of the given element as a NonEmpty value object.
 */
final public function childToNonEmpty(DOMElement $root, string $name, string $type = NonEmpty::class): ?NonEmpty
{
    if (null === $value = $this->childValue($root, $name)) {
        return null;
    }
    return $this->toNonEmpty($value, $type);
}

/**
* Converts string value to NonEmpty value object.
*/
final public function toNonEmpty(string $value, string $type = NonEmpty::class): NonEmpty
{
    $isValid = is_a($type, NonEmpty::class, true);
    Assert::true($isValid, 'INVALID TYPE');

    return ...
}
 ```

4. Créer une Exception **ArticleNotFound** avec le message : "Aucun article n'a été trouvé pour cette url {{ URL de
   l'article à récupérer avec la fonction transform }}"
