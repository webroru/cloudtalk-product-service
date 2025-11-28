<?php

declare(strict_types=1);

namespace App\Application\Shared\Bus\Query;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): ResponseInterface|null;
}
