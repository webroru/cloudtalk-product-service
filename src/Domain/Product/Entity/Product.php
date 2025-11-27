<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity;

use App\Domain\Product\ValueObject\ProductId;

class Product implements ProductInterface
{
    public function __construct(
        private readonly ProductId $id,
        private string $name,
        private float $price,
        private ?string $description
    ) {
    }

    public function getId(): ProductId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getAverage(): float
    {
        // TODO: Implement getAverage() method.
    }
}
