<?php

declare(strict_types=1);

namespace App\Tests\Product\Application\Command\UpdateProduct;

use App\Application\Command\UpdateProduct\UpdateProductCommand;
use App\Application\Command\UpdateProduct\UpdateProductCommandHandler;
use App\Domain\Entity\ProductInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;

class UpdateProductCommandHandlerTest extends TestCase
{
    public function testItUpdateProductAndSavesToRepository(): void
    {
        $repository = $this->createMock(ProductRepositoryInterface::class);
        $existingProduct = $this->createMock(ProductInterface::class);

        $repository
            ->expects(self::once())
            ->method('save')
            ->with(self::isInstanceOf(ProductInterface::class));

        $repository
            ->expects(self::once())
            ->method('findById')
            ->with('abc123')
            ->willReturn($existingProduct);

        $handler = new UpdateProductCommandHandler($repository);

        $command = new UpdateProductCommand(
            id: 'abc123',
            name: 'New name',
            description: 'New desc',
            price: 99.9,
        );

        $handler($command);
    }
}
