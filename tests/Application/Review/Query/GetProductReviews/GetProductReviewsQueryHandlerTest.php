<?php

declare(strict_types=1);

namespace App\Tests\Application\Review\Query\GetProductReviews;

use App\Application\Product\Query\GetProductReviews\GetProductReviewsQuery;
use App\Application\Product\Query\GetProductReviews\GetProductReviewsQueryHandler;
use App\Domain\Product\ValueObject\ProductId;
use App\Domain\Review\Entity\Review;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use App\Domain\Review\ValueObject\Rating;
use App\Domain\Review\ValueObject\ReviewId;
use PHPUnit\Framework\TestCase;

class GetProductReviewsQueryHandlerTest extends TestCase
{
    public function testHandlerReturnsReviewDetailsDto(): void
    {
        $reviewId = ReviewId::generate();
        $productId = ProductId::generate();
        $rating = new Rating(5);
        $review = new Review(
            id: $reviewId,
            productId: $productId,
            firstName: 'John',
            lastName: 'Doe',
            text: 'Great product!',
            rating: $rating,
        );

        $repository = $this->createMock(ReviewRepositoryInterface::class);

        $repository
            ->expects(self::once())
            ->method('findByProductId')
            ->with($productId->toString())
            ->willReturn([$review]);

        $handler = new GetProductReviewsQueryHandler($repository);

        $query = new GetProductReviewsQuery($productId);
        $getReviewByIdResponse = $handler($query);

        self::assertSame($review->getId()->toString(), $getReviewByIdResponse->reviews[0]->id);
        self::assertSame($review->getFirstName(), $getReviewByIdResponse->reviews[0]->firstName);
        self::assertSame($review->getLastName(), $getReviewByIdResponse->reviews[0]->lastName);
        self::assertSame($review->getText(), $getReviewByIdResponse->reviews[0]->text);
        self::assertSame($review->getRating()->getValue(), $getReviewByIdResponse->reviews[0]->rating);
    }
}
