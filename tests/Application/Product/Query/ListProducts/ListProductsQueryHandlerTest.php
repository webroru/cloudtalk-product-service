<?php

declare(strict_types=1);

namespace App\Tests\Application\Product\Query\ListProducts;

use App\Application\Product\Query\ListProducts\ListProductsQuery;
use App\Application\Product\Query\ListProducts\ListProductsQueryHandler;
use App\Application\Product\Service\ProductRatingService;
use App\Domain\Product\Entity\Product;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Domain\Product\ValueObject\ProductId;
use PHPUnit\Framework\TestCase;

final class ListProductsQueryHandlerTest extends TestCase
{
    public function testItReturnsListOfProductDtos(): void
    {
        $uuid = ProductId::generate();
        $product = new Product(
            id: $uuid,
            name: 'Existing Product',
            price: 0.99,
            description: 'An existing product in the repository',
        );

        $repository = $this->createMock(ProductRepositoryInterface::class);
        $redis = $this->createMock(\Redis::class);
        $ratingService = new ProductRatingService($redis);

        $repository
            ->method('findAll')
            ->willReturn([$product]);

        $redis->expects(self::once())
            ->method('exists')
            ->willReturn(true);

        $redis->expects(self::once())
            ->method('get')
            ->willReturn(json_encode(['averageRating' => 4.5]));

        $handler = new ListProductsQueryHandler($repository, $ratingService);

        $query = new ListProductsQuery();
        $listProductsResponse = $handler($query);
        $products = $listProductsResponse->products;

        self::assertSame($product->getId()->toString(), $products[0]->id);
        self::assertSame($product->getName(), $products[0]->name);
        self::assertSame($product->getPrice(), $products[0]->price);
        self::assertSame($product->getDescription(), $products[0]->description);
    }
}
