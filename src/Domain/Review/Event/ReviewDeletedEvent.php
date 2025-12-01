<?php

declare(strict_types=1);

namespace App\Domain\Review\Event;

final readonly class ReviewDeletedEvent implements EventInterface
{
    public function __construct(
        public string $reviewId,
    ) {
    }
}
