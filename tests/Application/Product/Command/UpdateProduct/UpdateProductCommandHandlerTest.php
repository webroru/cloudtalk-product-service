<?php

declare(strict_types=1);

namespace App\Tests\Application\Product\Command\UpdateProduct;

use App\Application\Product\Command\UpdateProduct\UpdateProductCommand;
use App\Application\Product\Command\UpdateProduct\UpdateProductCommandHandler;
use App\Domain\Product\Entity\Product;
use App\Domain\Product\Entity\ProductInterface;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Domain\Product\ValueObject\ProductId;
use PHPUnit\Framework\TestCase;

class UpdateProductCommandHandlerTest extends TestCase
{
    public function testUpdateProductAndSavesToRepository(): void
    {
        $repository = $this->createMock(ProductRepositoryInterface::class);
        $uuid = ProductId::generate();
        $existingProduct = new Product(
            id: $uuid,
            name: 'Existing Product',
            price: 49.9,
            description: 'An existing product in the repository',
        );

        $repository
            ->expects(self::once())
            ->method('findById')
            ->with($uuid->toString())
            ->willReturn($existingProduct)
        ;

        $repository
            ->expects(self::once())
            ->method('save')
            ->with(self::isInstanceOf(ProductInterface::class))
        ;

        $handler = new UpdateProductCommandHandler($repository);

        $command = new UpdateProductCommand(
            id: $uuid->toString(),
            name: 'New name',
            description: 'New desc',
            price: 99.9,
        );

        $handler($command);
    }
}
