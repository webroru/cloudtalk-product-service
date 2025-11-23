<?php

declare(strict_types=1);

namespace App\Tests\Product\Application\Query\GetProductById;

use App\Application\Query\GetProductById\GetProductByIdQuery;
use App\Application\Query\GetProductById\GetProductByIdQueryHandler;
use App\Application\Query\ProductDetailsDto;
use App\Domain\Entity\ProductInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetProductByIdQueryHandlerTest extends TestCase
{
    public function testHandlerReturnsProductDetailsDto(): void
    {
        $product = $this->createMock(ProductInterface::class);
        $product
            ->expects(self::once())
            ->method('getId')
            ->willReturn('abc123');

        $product
            ->expects(self::once())
            ->method('getName')
            ->willReturn('Name');

        $product
            ->expects(self::once())
            ->method('getDescription')
            ->willReturn('Desc');

        $product
            ->expects(self::once())
            ->method('getPrice')
            ->willReturn(99.0);

        $product
            ->expects(self::once())
            ->method('getAverageRating')
            ->willReturn(4.5);

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
        self::assertSame('abc123', $dto->id);
        self::assertSame('Name', $dto->name);
        self::assertSame('Desc', $dto->description);
        self::assertSame(99.0, $dto->price);
        self::assertSame(4.5, $dto->averageRating);
    }
}
