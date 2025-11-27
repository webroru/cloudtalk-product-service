<?php

declare(strict_types=1);

namespace App\Domain\Review\Factory;

use App\Domain\Product\ValueObject\ProductId;
use App\Domain\Review\Entity\ReviewInterface;
use App\Domain\Review\ValueObject\Rating;

interface ReviewFactoryInterface
{
    public function create(
        ProductId $productId,
        string $firstName,
        string $lastName,
        string $text,
        Rating $rating,
    ): ReviewInterface;
}
