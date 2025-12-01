<?php

declare(strict_types=1);

namespace App\Domain\Review\Event;

final readonly class ReviewCreatedEvent implements EventInterface
{
    public function __construct(
        public string $reviewId,
        public string $productId,
        public float $rating,
    ) {
    }
}
