<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Product\Entity\Product;
use App\Domain\Product\Entity\ProductInterface;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Domain\Product\ValueObject\ProductId;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public function save(ProductInterface $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }

    public function remove(ProductInterface $product): void
    {
        $this->em->remove($product);
        $this->em->flush();
    }

    public function findById(ProductId $id): ProductInterface
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
}
