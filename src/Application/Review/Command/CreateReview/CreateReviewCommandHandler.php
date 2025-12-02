<?php

declare(strict_types=1);

namespace App\Application\Review\Command\CreateReview;

use App\Application\Review\Command\Trait\ReviewCacheTrait;
use App\Application\Shared\Bus\Command\CommandHandlerInterface;
use App\Application\Shared\Bus\Event\EventBusInterface;
use App\Domain\Review\Event\ReviewCreatedEvent;
use App\Domain\Review\Factory\ReviewFactoryInterface;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use Symfony\Contracts\Cache\CacheInterface;

final readonly class CreateReviewCommandHandler implements CommandHandlerInterface
{
    use ReviewCacheTrait;

    public function __construct(
        private ReviewFactoryInterface $factory,
        private ReviewRepositoryInterface $repository,
        private EventBusInterface $eventBus,
        private CacheInterface $cache,
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
        $this->clearCacheForProduct($review->getProductId()->toString());

        $this->eventBus->dispatch(
            new ReviewCreatedEvent(
                productId: $review->getProductId()->toString(),
                rating: $review->getRating()->getValue(),
            )
        );
    }
}
