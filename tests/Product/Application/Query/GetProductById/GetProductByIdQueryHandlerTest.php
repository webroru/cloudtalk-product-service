<?php

declare(strict_types=1);

namespace App\Tests\Product\Application\Query\GetProductById;

use App\Application\Query\GetProductById\GetProductByIdQuery;
use App\Application\Query\GetProductById\GetProductByIdQueryHandler;
use App\Application\Query\ProductDetailsDto;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetProductByIdQueryHandlerTest extends TestCase
{
    public function testHandlerReturnsProductDetailsDto(): void
    {
        $product = new Product(
            id: 'abc123',
            name: 'Name',
            description: 'Desc',
        );

        $repository = $this->createMock(ProductRepositoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('findById')
            ->with('abc123')
            ->willReturn($product);

        $handler = new GetProductByIdQueryHandler($repository);

        $query = new GetProductByIdQuery('abc123');
        $dto = $handler($query);

        self::assertInstanceOf(ProductDetailsDto::class, $dto);
        self::assertSame($product->getUuid(), $dto->uiid);
        self::assertSame($product->getName(), $dto->name);
        self::assertSame($product->getDescription(), $dto->description);
        self::assertSame($product->getPrice(), $dto->price);
        self::assertSame($product->getAverage(), $dto->averageRating);
    }
}
