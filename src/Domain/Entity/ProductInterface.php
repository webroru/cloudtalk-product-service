<?php

declare(strict_types=1);

namespace App\Domain\Entity;

interface ProductInterface
{
    public function getId(): string;
    public function getName(): string;
    public function setName(string $name): self;
    public function getDescription(): string;
    public function setDescription(string $description): self;
    public function getPrice(): float;
    public function setPrice(float $price): self;
    public function getAverage(): float;
}
