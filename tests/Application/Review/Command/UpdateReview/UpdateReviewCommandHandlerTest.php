<?php

declare(strict_types=1);

namespace App\Tests\Application\Review\Command\UpdateReview;

use App\Application\Review\Command\UpdateReview\UpdateReviewCommand;
use App\Application\Review\Command\UpdateReview\UpdateReviewCommandHandler;
use App\Application\Shared\Event\EventBusInterface;
use App\Domain\Product\ValueObject\ProductId;
use App\Domain\Review\Entity\Review;
use App\Domain\Review\Entity\ReviewInterface;
use App\Domain\Review\Event\ReviewCreatedEvent;
use App\Domain\Review\Event\ReviewUpdatedEvent;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use App\Domain\Review\ValueObject\Rating;
use App\Domain\Review\ValueObject\ReviewId;
use PHPUnit\Framework\TestCase;

class UpdateReviewCommandHandlerTest extends TestCase
{
    public function testUpdateReviewAndSavesToRepository(): void
    {
        $repository = $this->createMock(ReviewRepositoryInterface::class);
        $eventBus = $this->createMock(EventBusInterface::class);

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
            ->willReturn($review)
        ;

        $repository
            ->expects(self::once())
            ->method('save')
            ->with(self::isInstanceOf(ReviewInterface::class))
        ;

        $eventBus
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(ReviewUpdatedEvent::class));

        $handler = new UpdateReviewCommandHandler($repository, $eventBus);

        $command = new UpdateReviewCommand(
            id: $reviewId,
            productId: $productId,
            firstName: 'Jane',
            lastName: 'Smith',
            text: 'Updated review text',
            rating: $rating,
        );

        $handler($command);
    }
}
