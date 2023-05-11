<?php

namespace App\Handler;

interface QueryBusInterface
{
    public function query(object $query): mixed;
}
