<?php

declare(strict_types=1);

namespace App\Domain\Review\Repository;

use App\Domain\Product\ValueObject\ProductId;
use App\Domain\Review\Entity\ReviewInterface;
use App\Domain\Review\ValueObject\ReviewId;

interface ReviewRepositoryInterface
{
    /** @return ReviewInterface[] */
    public function findAll(): array;
    public function findById(ReviewId $id): ?ReviewInterface;
    /** @return ReviewInterface[] */
    public function findByProductId(ProductId $id): array;
    public function save(ReviewInterface $product): void;
    public function delete(ReviewInterface $product): void;
}
