<?php

declare(strict_types=1);

namespace App\Application\Review\Command\UpdateReview;

use App\Application\Review\Command\Trait\ReviewCacheTrait;
use App\Application\Shared\Bus\Command\CommandHandlerInterface;
use App\Application\Shared\Bus\Event\EventBusInterface;
use App\Domain\Review\Event\ReviewUpdatedEvent;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use Symfony\Contracts\Cache\CacheInterface;

final readonly class UpdateReviewCommandHandler implements CommandHandlerInterface
{
    use ReviewCacheTrait;

    public function __construct(
        private ReviewRepositoryInterface $repository,
        private EventBusInterface $eventBus,
        private CacheInterface $cache,
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
        $this->clearCacheForProduct($review->getProductId()->toString());

        $this->eventBus->dispatch(
            new ReviewUpdatedEvent(
                reviewId: $review->getId()->toString(),
                productId: $review->getProductId()->toString(),
                rating: $review->getRating()->getValue(),
            )
        );
    }
}
