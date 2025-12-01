<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Product\Entity\Product;
use App\Domain\Product\Entity\ProductInterface;
use App\Domain\Product\ValueObject\ProductId;
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

    public function save(ReviewInterface $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }

    public function remove(ReviewInterface $product): void
    {
        $this->em->remove($product);
        $this->em->flush();
    }

    public function findById(ReviewId $id): ReviewInterface
    {
        $product = $this->em->getRepository(Product::class)->find($id);

        if (!$product instanceof ProductInterface) {
            throw new \RuntimeException(sprintf('Product with id "%s" not found', $id->toString()));
        }

        return $product;
    }

    /** @return ProductInterface[] */
    public function findAll(): array
    {
        return $this->em->getRepository(Product::class)->findAll();
    }

    public function findByProductId(ProductId $id): array
    {
        return $this->em->getRepository(Product::class)->findBy(['product' => $id]);
    }
}
