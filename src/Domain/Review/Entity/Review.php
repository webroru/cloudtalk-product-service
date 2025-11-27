<?php

declare(strict_types=1);

namespace App\Domain\Review\Entity;

use App\Domain\Product\ValueObject\ProductId;
use App\Domain\Review\ValueObject\Rating;
use App\Domain\Review\ValueObject\ReviewId;

class Review implements ReviewInterface
{
    public function __construct(
        private readonly ReviewId $id,
        private ProductId $productId,
        private string $firstName,
        private string $lastName,
        private string $text,
        private Rating $rating,
    ) {
    }

    public function getId(): ReviewId
    {
        return $this->id;
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    public function setProductId(ProductId $productId): self
    {
        $this->productId = $productId;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getRating(): Rating
    {
        return $this->rating;
    }

    public function setRating(Rating $rating): self
    {
        $this->rating = $rating;
        return $this;
    }
}
