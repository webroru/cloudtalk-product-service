<?php

declare(strict_types=1);

namespace App\Tests\Application\Product\Query\GetProductById;

use App\Application\Product\Query\GetProductById\GetProductByIdQuery;
use App\Application\Product\Query\GetProductById\GetProductByIdQueryHandler;
use App\Domain\Product\Entity\Product;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Domain\Product\ValueObject\ProductId;
use PHPUnit\Framework\TestCase;

class GetProductByIdQueryHandlerTest extends TestCase
{
    public function testHandlerReturnsProductDetailsDto(): void
    {
        $uuid = ProductId::generate();
        $product = new Product(
            id: $uuid,
            name: 'Existing Product',
            price: 0.99,
            description: 'An existing product in the repository',
        );

        $repository = $this->createMock(ProductRepositoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('findById')
            ->with($uuid->toString())
            ->willReturn($product);

        $handler = new GetProductByIdQueryHandler($repository);

        $query = new GetProductByIdQuery($uuid);
        $getProductByIdResponse = $handler($query);

        self::assertSame($product->getId()->toString(), $getProductByIdResponse->productDto->id);
        self::assertSame($product->getName(), $getProductByIdResponse->productDto->name);
        self::assertSame($product->getPrice(), $getProductByIdResponse->productDto->price);
        self::assertSame($product->getDescription(), $getProductByIdResponse->productDto->description);
    }
}
