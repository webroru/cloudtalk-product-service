<?php

declare(strict_types=1);

namespace App\Tests\Product\Application\Command\UpdateProduct;

use App\Application\Command\CreateProduct\UpdateProductCommand;
use App\Application\Command\CreateProduct\UpdateProductCommandHandler;
use App\Domain\Entity\ProductInterface;
use App\Domain\Factory\ProductFactoryInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;

class UpdateProductCommandHandlerTest extends TestCase
{
    public function testItUpdateProductAndSavesToRepository(): void
    {
        $repository = $this->createMock(ProductRepositoryInterface::class);
        $factory = $this->createMock(ProductFactoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('save')
            ->with(self::isInstanceOf(ProductInterface::class));

        $handler = new UpdateProductCommandHandler($repository, $factory);

        $command = new UpdateProductCommand(
            id: 'abc123',
            name: 'New name',
            description: 'New desc',
            price: 99.9,
        );

        $updated = $handler($command);

        self::assertSame('New name', $updated->getName());
        self::assertSame('New desc', $updated->getDescription());
        self::assertSame(99.9, $updated->getPrice());

    }
}
