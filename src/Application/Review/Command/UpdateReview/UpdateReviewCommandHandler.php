<?php

declare(strict_types=1);

namespace App\Application\Review\Command\UpdateReview;

use App\Application\Shared\Bus\Command\CommandHandlerInterface;
use App\Application\Shared\Bus\Event\EventBusInterface;
use App\Domain\Review\Event\ReviewUpdatedEvent;
use App\Domain\Review\Repository\ReviewRepositoryInterface;

final readonly class UpdateReviewCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ReviewRepositoryInterface $repository,
        private EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(UpdateReviewCommand $command): void
    {
        $review = $this->repository->findById($command->id);

        if ($review === null) {
            throw new \RuntimeException('Review not found.');
        }

        $review
            ->setProductId($command->productId)
            ->setFirstName($command->firstName)
            ->setLastName($command->lastName)
            ->setText($command->text)
            ->setRating($command->rating)
        ;

        $this->repository->save($review);

        $this->eventBus->dispatch(
            new ReviewUpdatedEvent(
                reviewId: $review->getId()->toString(),
                productId: $review->getProductId()->toString(),
                rating: $review->getRating()->getValue(),
            )
        );
    }
}
