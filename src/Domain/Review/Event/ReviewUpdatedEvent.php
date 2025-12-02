<?php

declare(strict_types=1);

namespace App\Domain\Review\Event;

final readonly class ReviewUpdatedEvent implements EventInterface
{
    public function __construct(
        public string $productId,
        public float $oldRating,
        public float $newRating,
    ) {
    }
}
