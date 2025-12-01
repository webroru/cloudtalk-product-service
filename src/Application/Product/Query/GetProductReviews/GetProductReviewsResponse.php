<?php

declare(strict_types=1);

namespace App\Application\Product\Query\GetProductReviews;

use App\Application\Product\Query\DTO\ReviewDto;
use App\Application\Shared\Bus\Query\ResponseInterface;

final readonly class GetProductReviewsResponse implements ResponseInterface
{
    /**
     * @param ReviewDto[] $reviews
     */
    public function __construct(
        public array $reviews
    ) {
    }
}
