<?php

declare(strict_types=1);

namespace App\Exception;

class ArticleNotFound extends \DomainException
{
    public function __construct(string $url)
    {
        parent::__construct(
            sprintf("Aucun article n'a été trouvé pour cette url {{ <%s> }}", $url),
        );
    }
}
