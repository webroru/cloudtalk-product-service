<?php

declare(strict_types=1);

namespace App\Tests\Application\Command\UpdateProduct;

use App\Application\Command\UpdateProduct\UpdateProductCommand;
use App\Application\Command\UpdateProduct\UpdateProductCommandHandler;
use App\Domain\Entity\Product;
use App\Domain\Entity\ProductInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\ValueObject\ProductId;
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
