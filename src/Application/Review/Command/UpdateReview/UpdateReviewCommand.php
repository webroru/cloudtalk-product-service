<?php

declare(strict_types=1);

namespace App\Application\Review\Command\UpdateReview;

use App\Domain\Bus\Command\CommandInterface;
use App\Domain\Product\ValueObject\ProductId;
use App\Domain\Review\ValueObject\Rating;
use App\Domain\Review\ValueObject\ReviewId;

final readonly class UpdateReviewCommand implements CommandInterface
{
    public function __construct(
        public ReviewId $id,
        public ProductId $productId,
        public string $firstName,
        public string $lastName,
        public string $text,
        public Rating $rating,
    ) {
    }
}
