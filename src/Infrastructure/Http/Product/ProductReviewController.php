<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Product;

use App\Application\Product\Query\GetProductReviews\GetProductReviewsQuery;
use App\Application\Product\Query\GetProductReviews\GetProductReviewsResponse;
use App\Application\Shared\Bus\Query\QueryBusInterface;
use App\Domain\Product\ValueObject\ProductId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ProductReviewController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    #[Route('/products/{id}/reviews', name: 'product_reviews', methods: ['GET'])]
    public function reviews(
        string $id,
    ): JsonResponse {
        /** @var GetProductReviewsResponse $response */
        $response = $this->queryBus->ask(
            new GetProductReviewsQuery(ProductId::fromString($id))
        );

        return $this->json($response->reviews);
    }
}
