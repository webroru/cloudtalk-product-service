<?php

declare(strict_types=1);

namespace App\Tests\Product\Application\Command\DeleteProduct;

use App\Application\Command\DeleteProduct\DeleteProductCommand;
use App\Application\Command\DeleteProduct\DeleteProductCommandHandler;
use App\Domain\Entity\ProductInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;

class DeleteProductCommandHandlerTest extends TestCase
{
    public function testDeleteProduct(): void
    {
        $repository = $this->createMock(ProductRepositoryInterface::class);
        $existingProduct = $this->createMock(ProductInterface::class);

        $repository
            ->expects(self::once())
            ->method('findById')
            ->with('abc123')
            ->willReturn($existingProduct);

        $repository
            ->expects(self::once())
            ->method('delete')
            ->with(self::isInstanceOf(ProductInterface::class));

        $handler = new DeleteProductCommandHandler($repository);

        $command = new DeleteProductCommand(
            id: 'abc123',
        );

        $handler($command);
    }
}
