<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Review;

use App\Application\Review\Command\CreateReview\CreateReviewCommand;
use App\Application\Review\Command\DeleteReview\DeleteReviewCommand;
use App\Application\Review\Command\UpdateReview\UpdateReviewCommand;
use App\Application\Shared\Bus\Command\CommandBusInterface;
use App\Domain\Product\ValueObject\ProductId;
use App\Domain\Review\ValueObject\Rating;
use App\Domain\Review\ValueObject\ReviewId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ReviewController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/reviews', name: 'review_create', methods: ['POST'])]
    public function create(
        Request $request,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $command = new CreateReviewCommand(
            productId: ProductId::fromString($data['productId']),
            firstName: $data['firstName'],
            lastName: $data['lastName'],
            text: $data['text'],
            rating: new Rating((int)$data['rating']),
        );
        $this->commandBus->dispatch($command);

        return new JsonResponse(['status' => 'ok'], 201);
    }

    #[Route('/reviews/{id}', name: 'review_update', methods: ['PUT'])]
    public function update(
        string $id,
        Request $request,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $command = new UpdateReviewCommand(
            id: ReviewId::fromString($id),
            productId: ProductId::fromString($data['productId']),
            firstName: $data['firstName'],
            lastName: $data['lastName'],
            text: $data['text'],
            rating: new Rating((int)$data['rating']),
        );
        $this->commandBus->dispatch($command);

        return $this->json(['status' => 'ok']);
    }

    #[Route('/reviews/{id}', name: 'review_delete', methods: ['DELETE'])]
    public function delete(
        string $id,
    ): JsonResponse {
        $command = new DeleteReviewCommand(
            id: ReviewId::fromString($id),
        );
        $this->commandBus->dispatch($command);

        return $this->json(['status' => 'deleted']);
    }
}
