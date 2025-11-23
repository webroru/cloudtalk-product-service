<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Symfony\Component\Uid\Uuid;

interface ProductInterface
{
    public function getName(): Uuid;
    public function setName(string $name): self;
    public function getDescription(): string;
    public function setDescription(string $description): self;
    public function getPrice(): float;
    public function setPrice(float $price): self;
    public function getAverage(): float;
}
