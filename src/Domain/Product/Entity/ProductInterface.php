<?php

declare(strict_types=1);

namespace App\Domain\Product\Entity;

use App\Domain\Product\ValueObject\ProductId;

interface ProductInterface
{
    public function getId(): ProductId;
    public function getName(): string;
    public function setName(string $name): self;
    public function getDescription(): string;
    public function setDescription(string $description): self;
    public function getPrice(): float;
    public function setPrice(float $price): self;
}
