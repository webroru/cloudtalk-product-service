<?php

declare(strict_types=1);

namespace App\Application\Query\GetProductById;

use App\Domain\ValueObject\ProductId;

final readonly class GetProductByIdQuery
{
    public function __construct(private ProductId $id)
    {
    }

    public function id(): ProductId
    {
        return $this->id;
    }
}
