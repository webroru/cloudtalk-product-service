<?php

declare(strict_types=1);

namespace App\Application\Review\Query\GetProductReviews;

use App\Application\Shared\Bus\Query\QueryHandlerInterface;
use App\Domain\Review\Entity\ReviewInterface;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use App\Application\Review\Query\DTO\ReviewDto;

final readonly class GetProductReviewsQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ReviewRepositoryInterface $repository
    ) {
    }

    public function __invoke(GetProductReviewsQuery $query): GetProductReviewsResponse
    {
        /** @var ReviewInterface[] $reviews */
        $reviews = $this->repository->findByProductId($query->productId->toString());

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
