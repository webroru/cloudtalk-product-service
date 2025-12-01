<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Product\Entity\ProductInterface;
use App\Domain\Product\ValueObject\ProductId;
use App\Domain\Review\Entity\Review;
use App\Domain\Review\Entity\ReviewInterface;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use App\Domain\Review\ValueObject\ReviewId;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineReviewRepository implements ReviewRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public function save(ReviewInterface $review): void
    {
        $this->em->persist($review);
        $this->em->flush();
    }

    public function remove(ReviewInterface $product): void
    {
        $this->em->remove($product);
        $this->em->flush();
    }

    public function findById(ReviewId $id): ReviewInterface
    {
        $review = $this->em->getRepository(Review::class)->find($id);

        if (!$review instanceof ReviewInterface) {
            throw new \RuntimeException(sprintf('Review with id "%s" not found', $id->toString()));
        }

        return $review;
    }

    /** @return ProductInterface[] */
    public function findAll(): array
    {
        return $this->em->getRepository(Review::class)->findAll();
    }

    public function findByProductId(ProductId $id): array
    {
        return $this->em->getRepository(Review::class)->findBy(['product' => $id]);
    }
}
