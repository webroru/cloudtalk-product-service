<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Domain\Product\ValueObject\ProductId;
use App\Domain\Review\Entity\Review;
use App\Domain\Review\Factory\ReviewFactoryInterface;
use App\Domain\Review\ValueObject\Rating;
use App\Domain\Review\ValueObject\ReviewId;

final class ReviewFactory implements ReviewFactoryInterface
{
    public function create(ProductId $productId, string $firstName, string $lastName, string $text, Rating $rating): Review
    {
        return new Review(
            id: ReviewId::generate(),
            productId: $productId,
            firstName: $firstName,
            lastName: $lastName,
            text: $text,
            rating: $rating,
        );
    }
}
