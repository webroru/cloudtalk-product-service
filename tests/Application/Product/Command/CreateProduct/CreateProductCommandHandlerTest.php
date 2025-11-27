<?php

declare(strict_types=1);

namespace App\Tests\Application\Product\Command\CreateProduct;

use App\Application\Product\Command\CreateProduct\CreateProductCommand;
use App\Application\Product\Command\CreateProduct\CreateProductCommandHandler;
use App\Domain\Product\Entity\ProductInterface;
use App\Domain\Product\Factory\ProductFactoryInterface;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateProductCommandHandlerTest extends TestCase
{
    public function testCreateProductAndSavesToRepository(): void
    {
        $repository = $this->createMock(ProductRepositoryInterface::class);
        $factory = $this->createMock(ProductFactoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('save')
            ->with(self::isInstanceOf(ProductInterface::class));

        $handler = new CreateProductCommandHandler($repository, $factory);

        $command = new CreateProductCommand(
            name: 'Test',
            description: 'Desc',
            price: 100.0,
        );

        $handler($command);
    }
}
