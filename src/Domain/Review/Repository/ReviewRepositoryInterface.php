<?php

declare(strict_types=1);

namespace App\Domain\Review\Repository;

use App\Domain\Review\Entity\ReviewInterface;

interface ReviewRepositoryInterface
{
    public function findAll(): array;
    public function findById(string $id): ?ReviewInterface;
    public function findByProductId(string $id): array;
    public function save(ReviewInterface $product): void;
    public function delete(ReviewInterface $product): void;
}
