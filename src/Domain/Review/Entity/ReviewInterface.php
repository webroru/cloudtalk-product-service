<?php

declare(strict_types=1);

namespace App\Domain\Review\Entity;

use App\Domain\Product\ValueObject\ProductId;
use App\Domain\Review\ValueObject\Rating;
use App\Domain\Review\ValueObject\ReviewId;

interface ReviewInterface
{
    public function getId(): ReviewId;
    public function getProductId(): ProductId;
    public function setProductId(ProductId $productId): self;
    public function getFirstName(): string;
    public function setFirstName(string $firstName): self;
    public function getLastName(): string;
    public function setLastName(string $lastName): self;
    public function getText(): string;
    public function setText(string $text): self;
    public function getRating(): Rating;
    public function setRating(Rating $rating): self;
}
