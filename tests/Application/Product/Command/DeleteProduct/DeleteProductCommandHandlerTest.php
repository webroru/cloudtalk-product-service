<?php

declare(strict_types=1);

namespace App\Tests\Application\Product\Command\DeleteProduct;

use App\Application\Product\Command\DeleteProduct\DeleteProductCommand;
use App\Application\Product\Command\DeleteProduct\DeleteProductCommandHandler;
use App\Domain\Product\Entity\Product;
use App\Domain\Product\Entity\ProductInterface;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Domain\Product\ValueObject\ProductId;
use PHPUnit\Framework\TestCase;

class DeleteProductCommandHandlerTest extends TestCase
{
    public function testDeleteProduct(): void
    {
        $repository = $this->createMock(ProductRepositoryInterface::class);
        $uuid = ProductId::generate();
        $existingProduct = new Product(
            id: $uuid,
            name: 'Existing Product',
            price: 49.99,
            description: 'An existing product in the repository',
        );

        $repository
            ->expects(self::once())
            ->method('findById')
            ->with($uuid->toString())
            ->willReturn($existingProduct);

        $repository
            ->expects(self::once())
            ->method('delete')
            ->with(self::isInstanceOf(ProductInterface::class));

        $handler = new DeleteProductCommandHandler($repository);

        $command = new DeleteProductCommand(
            id: $uuid->toString(),
        );

        $handler($command);
    }
}
