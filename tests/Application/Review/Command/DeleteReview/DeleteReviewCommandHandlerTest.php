<?php

declare(strict_types=1);

namespace App\Tests\Application\Review\Command\DeleteReview;

use App\Application\Review\Command\DeleteReview\DeleteReviewCommand;
use App\Application\Review\Command\DeleteReview\DeleteReviewCommandHandler;
use App\Application\Shared\Bus\Event\EventBusInterface;
use App\Domain\Product\ValueObject\ProductId;
use App\Domain\Review\Entity\Review;
use App\Domain\Review\Entity\ReviewInterface;
use App\Domain\Review\Event\ReviewDeletedEvent;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use App\Domain\Review\ValueObject\Rating;
use App\Domain\Review\ValueObject\ReviewId;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Cache\CacheInterface;

class DeleteReviewCommandHandlerTest extends TestCase
{
    public function testDeleteReview(): void
    {
        $repository = $this->createMock(ReviewRepositoryInterface::class);
        $eventBus = $this->createMock(EventBusInterface::class);
        $cache = $this->createMock(CacheInterface::class);

        $reviewId = ReviewId::generate();
        $productId = ProductId::generate();
        $rating = new Rating(5);

        $review = new Review(
            id: $reviewId,
            productId: $productId,
            firstName: 'John',
            lastName: 'Doe',
            text: 'Nice product',
            rating: $rating,
        );

        $repository
            ->expects(self::once())
            ->method('findById')
            ->with($reviewId->toString())
            ->willReturn($review);

        $repository
            ->expects(self::once())
            ->method('remove')
            ->with(self::isInstanceOf(ReviewInterface::class));

        $eventBus
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(ReviewDeletedEvent::class));

        $cache->method('delete');

        $handler = new DeleteReviewCommandHandler($repository, $eventBus, $cache);

        $command = new DeleteReviewCommand(
            id: $reviewId,
        );

        $handler($command);
    }
}
