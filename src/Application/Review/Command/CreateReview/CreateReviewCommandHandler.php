<?php

declare(strict_types=1);

namespace App\Application\Review\Command\CreateReview;

use App\Application\Shared\Bus\Command\CommandHandlerInterface;
use App\Application\Shared\Bus\Event\EventBusInterface;
use App\Domain\Review\Event\ReviewCreatedEvent;
use App\Domain\Review\Factory\ReviewFactoryInterface;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use App\Domain\Review\ValueObject\ReviewId;

final readonly class CreateReviewCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ReviewFactoryInterface $factory,
        private ReviewRepositoryInterface $repository,
        private EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(CreateReviewCommand $command): void
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
                reviewId: $review->getId()->toString(),
                productId: $review->getProductId()->toString(),
                rating: $review->getRating()->getValue(),
            )
        );
    }
}
