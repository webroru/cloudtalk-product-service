<?php

declare(strict_types=1);

namespace App\Domain\Bus\Query;

interface QueryBusInterface
{
    public function ask(QueryInterface $query) : ResponseInterface|null;
}
