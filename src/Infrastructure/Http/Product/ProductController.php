<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Product;

use App\Application\Product\Command\CreateProduct\CreateProductCommand;
use App\Application\Product\Command\DeleteProduct\DeleteProductCommand;
use App\Application\Product\Command\UpdateProduct\UpdateProductCommand;
use App\Application\Product\Query\GetProductById\GetProductByIdQuery;
use App\Application\Product\Query\GetProductById\GetProductByIdResponse;
use App\Application\Product\Query\ListProducts\ListProductsQuery;
use App\Application\Product\Query\ListProducts\ListProductsResponse;
use App\Application\Shared\Bus\Command\CommandBusInterface;
use App\Application\Shared\Bus\Query\QueryBusInterface;
use App\Domain\Product\ValueObject\ProductId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    #[Route('/products', name: 'product_create', methods: ['POST'])]
    public function create(
        Request $request,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $command = new CreateProductCommand(
            name: $data['name'],
            description: $data['description'] ?? null,
            price: (float)$data['price'],
        );
        $this->commandBus->dispatch($command);

        return new JsonResponse(['status' => 'ok'], 201);
    }

    #[Route('/products/{id}', name: 'product_update', methods: ['PUT'])]
    public function update(
        string $id,
        Request $request,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $command = new UpdateProductCommand(
            id: ProductId::fromString($id),
            name: $data['name'],
            description: $data['description'] ?? null,
            price: (float)$data['price'],
        );
        $this->commandBus->dispatch($command);

        return $this->json(['status' => 'ok']);
    }

    #[Route('/products/{id}', name: 'product_delete', methods: ['DELETE'])]
    public function delete(
        string $id,
    ): JsonResponse {
        $command = new DeleteProductCommand(
            id: ProductId::fromString($id),
        );
        $this->commandBus->dispatch($command);

        return $this->json(['status' => 'deleted']);
    }

    #[Route('/products/{id}', name: 'product_get', methods: ['GET'])]
    public function get(
        string $id,
    ): JsonResponse {
        $query = new GetProductByIdQuery(
            id: ProductId::fromString($id),
        );
        /** @var GetProductByIdResponse $response */
        $response = $this->queryBus->ask($query);
        return $this->json($response->productDto);
    }

    #[Route('/products', name: 'product_list', methods: ['GET'])]
    public function list(
    ): JsonResponse {
        $query = new ListProductsQuery();
        /** @var ListProductsResponse $response */
        $response = $this->queryBus->ask($query);
        return $this->json($response->products);
    }
}
