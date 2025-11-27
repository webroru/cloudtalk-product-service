<?php

declare(strict_types=1);

namespace App\Application\Review\Command\CreateReview;

use App\Domain\Review\Factory\ReviewFactoryInterface;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use App\Domain\Review\ValueObject\ReviewId;
use App\Application\Shared\Event\EventBusInterface;
use App\Domain\Review\Event\ReviewCreatedEvent;

final readonly class CreateReviewCommandHandler
{
    public function __construct(
        private ReviewFactoryInterface $factory,
        private ReviewRepositoryInterface $repository,
        private EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(CreateReviewCommand $command): ReviewId
    {
        $review = $this->factory->create(
            productId: $command->productId,
            firstName: $command->firstName,
            lastName: $command->lastName,
            text: $command->text,
            rating: $command->rating,
        );

        $this->repository->save($review);

        $this->eventBus->dispatch(
            new ReviewCreatedEvent(
                reviewId: $review->getId(),
                productId: $review->getProductId(),
                rating: $review->getRating(),
            )
        );

        return $review->getId();
    }
}
