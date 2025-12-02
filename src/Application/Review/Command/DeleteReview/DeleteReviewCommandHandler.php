<?php

declare(strict_types=1);

namespace App\Application\Review\Command\DeleteReview;

use App\Application\Review\Command\Trait\ReviewCacheTrait;
use App\Application\Shared\Bus\Command\CommandHandlerInterface;
use App\Application\Shared\Bus\Event\EventBusInterface;
use App\Domain\Review\Event\ReviewDeletedEvent;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use Symfony\Contracts\Cache\CacheInterface;

final readonly class DeleteReviewCommandHandler implements CommandHandlerInterface
{
    use ReviewCacheTrait;

    public function __construct(
        private ReviewRepositoryInterface $repository,
        private EventBusInterface $eventBus,
        private CacheInterface $cache,
    ) {
    }

    public function __invoke(DeleteReviewCommand $command): void
    {
        $review = $this->repository->findById($command->id);

        if ($review === null) {
            throw new \RuntimeException('Review not found.');
        }

        $this->repository->remove($review);
        $this->clearCacheForProduct($review->getProductId()->toString());

        $this->eventBus->dispatch(
            new ReviewDeletedEvent(
                productId: $review->getProductId()->toString(),
                rating: $review->getRating()->getValue(),
            )
        );
    }
}
