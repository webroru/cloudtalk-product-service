<?php

declare(strict_types=1);

namespace App\Application\Product\Query\GetProductReviews;

use App\Application\Product\Query\GetProductReviews\GetProductReviewsQuery;
use App\Application\Product\Query\GetProductReviews\GetProductReviewsResponse;
use App\Application\Shared\Bus\Query\QueryHandlerInterface;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use App\Application\Product\Query\DTO\ReviewDto;

final readonly class GetProductReviewsQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ReviewRepositoryInterface $repository
    ) {
    }

    public function __invoke(GetProductReviewsQuery $query): GetProductReviewsResponse
    {
        $reviews = $this->repository->findByProductId($query->productId);

        $dtos = [];

        foreach ($reviews as $review) {
            $dtos[] = new ReviewDto(
                id: $review->getId()->toString(),
                firstName: $review->getFirstName(),
                lastName: $review->getLastName(),
                text: $review->getText(),
                rating: $review->getRating()->getValue(),
            );
        }

        return new GetProductReviewsResponse($dtos);
    }
}
