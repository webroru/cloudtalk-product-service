<?php

declare(strict_types=1);

namespace App\Tests\Product\Application\Command\CreateProduct;

use App\Application\Command\CreateProduct\CreateProductCommand;
use App\Application\Command\CreateProduct\CreateProductCommandHandler;
use App\Domain\Entity\ProductInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateProductCommandHandlerTest extends TestCase
{
    public function testItCreatesProductAndSavesToRepository(): void
    {
        $repository = $this->createMock(ProductRepositoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('save')
            ->with(self::isInstanceOf(ProductInterface::class));

        $handler = new CreateProductCommandHandler($repository);

        $command = new CreateProductCommand(
            name: 'Test',
            description: 'Desc',
            price: 100.0
        );

        $handler($command);
    }
}
