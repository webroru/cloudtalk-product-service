<?php

declare(strict_types=1);

namespace App\Tests\Application\Command\DeleteProduct;

use App\Application\Command\DeleteProduct\DeleteProductCommand;
use App\Application\Command\DeleteProduct\DeleteProductCommandHandler;
use App\Domain\Entity\Product;
use App\Domain\Entity\ProductInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\ValueObject\ProductId;
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
