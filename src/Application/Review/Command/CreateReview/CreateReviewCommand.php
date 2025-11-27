<?php

declare(strict_types=1);

namespace App\Application\Review\Command\CreateReview;

use App\Domain\Product\ValueObject\ProductId;
use App\Domain\Review\ValueObject\Rating;

final readonly class CreateReviewCommand
{
    public function __construct(
        public ProductId $productId,
        public string $firstName,
        public string $lastName,
        public string $text,
        public Rating $rating,
    ) {
    }
}
