<?php

declare(strict_types=1);

namespace App\Domain\Review\Event;

use App\Domain\Review\ValueObject\Rating;
use App\Domain\Review\ValueObject\ReviewId;
use App\Domain\Product\ValueObject\ProductId;

final readonly class ReviewCreatedEvent
{
    public function __construct(
        public ReviewId $reviewId,
        public ProductId $productId,
        public Rating $rating,
    ) {
    }
}
