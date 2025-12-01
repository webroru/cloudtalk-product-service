<?php

declare(strict_types=1);

namespace App\Application\Product\Query\GetProductReviews;

use App\Application\Shared\Bus\Query\QueryInterface;
use App\Domain\Product\ValueObject\ProductId;

final readonly class GetProductReviewsQuery implements QueryInterface
{
    public function __construct(
        public ProductId $productId,
    ) {
    }
}
