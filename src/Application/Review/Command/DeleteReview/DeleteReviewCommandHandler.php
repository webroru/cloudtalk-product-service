<?php

declare(strict_types=1);

namespace App\Application\Review\Command\DeleteReview;

use App\Application\Shared\Bus\Command\CommandHandlerInterface;
use App\Application\Shared\Bus\Event\EventBusInterface;
use App\Domain\Review\Event\ReviewDeletedEvent;
use App\Domain\Review\Repository\ReviewRepositoryInterface;

final readonly class DeleteReviewCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ReviewRepositoryInterface $repository,
        private EventBusInterface $eventBus,
    ) {
    }

    public function __invoke(DeleteReviewCommand $command): void
    {
        $review = $this->repository->findById($command->id);

        if ($review === null) {
            throw new \RuntimeException('Review not found.');
        }

        $this->repository->remove($review);

        $this->eventBus->dispatch(
            new ReviewDeletedEvent(
                reviewId: $review->getId()->toString(),
            )
        );
    }
}
