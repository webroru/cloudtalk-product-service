<?php

declare(strict_types=1);

namespace App\Tests\Application\Review\Command\CreateReview;

use App\Application\Review\Command\CreateReview\CreateReviewCommand;
use App\Application\Review\Command\CreateReview\CreateReviewCommandHandler;
use App\Application\Shared\Event\EventBusInterface;
use App\Domain\Product\ValueObject\ProductId;
use App\Domain\Review\Entity\ReviewInterface;
use App\Domain\Review\Event\ReviewCreatedEvent;
use App\Domain\Review\Factory\ReviewFactoryInterface;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use App\Domain\Review\ValueObject\Rating;
use App\Domain\Review\ValueObject\ReviewId;
use PHPUnit\Framework\TestCase;

final class CreateReviewCommandHandlerTest extends TestCase
{
    public function testItCreatesReviewAndSavesItAndEmitsEvent(): void
    {
        $productId = ProductId::generate();
        $reviewId = ReviewId::generate();
        $rating = new Rating(5);

        $command = new CreateReviewCommand(
            productId: $productId,
            firstName: 'John',
            lastName: 'Doe',
            text: 'Nice product',
            rating: $rating,
        );

        $repository = $this->createMock(ReviewRepositoryInterface::class);
        $factory = $this->createMock(ReviewFactoryInterface::class);
        $eventBus = $this->createMock(EventBusInterface::class);
        $review = $this->createMock(ReviewInterface::class);

        $factory
            ->expects($this->once())
            ->method('create')
            ->willReturn($review);

        $repository
            ->expects($this->once())
            ->method('save')
            ->with($review);

        $eventBus
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->isInstanceOf(ReviewCreatedEvent::class)
            );

        $review
            ->method('getId')
            ->willReturn($reviewId);

        $review
            ->method('getProductId')
            ->willReturn($productId);

        $review
            ->method('getRating')
            ->willReturn($rating);

        $handler = new CreateReviewCommandHandler($factory, $repository, $eventBus);

        $handler($command);
    }
}
