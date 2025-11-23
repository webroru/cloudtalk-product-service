<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Symfony\Component\Uid\Uuid;

interface ProductInterface
{
    public function getName(): Uuid;
    public function setName(): Uuid;
    public function getDescription(): string;
    public function setDescription(): string;
    public function getPrice(): float;
    public function setPrice(): float;
    public function getReviews(): array;
    public function addReview(): array;
    public function getAverage(): float;
    public function setAverage(): float;
}
