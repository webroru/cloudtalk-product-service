<?php

declare(strict_types=1);

namespace App\Tests\Product\Application\Command\CreateProduct;

use App\Product\Application\Command\CreateProduct\CreateProductCommand;
use App\Product\Application\Command\CreateProduct\CreateProductCommandHandler;
use App\Product\Domain\Product;
use App\Product\Domain\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateProductCommandHandlerTest extends TestCase
{
    public function testItCreatesProductAndSavesToRepository(): void
    {
        $repository = $this->createMock(ProductRepositoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('save')
            ->with(self::callback(function (Product $product) {
                return $product->getName() === 'Test'
                    && $product->getDescription() === 'Desc'
                    && $product->getPrice() === 100.0;
            }));

        $handler = new CreateProductCommandHandler($repository);

        $command = new CreateProductCommand(
            name: 'Test',
            description: 'Desc',
            price: 100.0
        );

        $handler($command);
    }
}
