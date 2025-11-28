<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Product;

use App\Application\Product\Command\CreateProduct\CreateProductCommand;
use App\Application\Product\Command\DeleteProduct\DeleteProductCommand;
use App\Application\Product\Command\UpdateProduct\UpdateProductCommand;
use App\Application\Product\Query\GetProductById\GetProductByIdQuery;
use App\Application\Product\Query\ListProducts\ListProductsQuery;
use App\Application\Shared\Bus\Command\CommandBusInterface;
use App\Application\Shared\Bus\Query\QueryBusInterface;
use App\Domain\Product\ValueObject\ProductId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_create', methods: ['POST'])]
    public function create(
        Request $request,
        CommandBusInterface $commandBus,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $command = new CreateProductCommand(
            name: $data['name'],
            description: $data['description'] ?? null,
            price: (float) $data['price'],
        );

        $result = $commandBus->dispatch($command);

        return $this->json(['id' => $result->id]);
    }

    #[Route('/products/{id}', name: 'product_update', methods: ['PUT'])]
    public function update(
        string $id,
        Request $request,
        CommandBusInterface $commandBus,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $command = new UpdateProductCommand(
            id: ProductId::fromString($id),
            name: $data['name'],
            description: $data['description'] ?? null,
            price: (float)$data['price'],
        );

        $commandBus->dispatch($command);

        return $this->json(['status' => 'ok']);
    }

    #[Route('/products/{id}', name: 'product_delete', methods: ['DELETE'])]
    public function delete(
        string $id,
        CommandBusInterface $commandBus,
    ): JsonResponse {
        $commandBus->dispatch(new DeleteProductCommand(ProductId::fromString($id)));

        return $this->json(['status' => 'deleted']);
    }

    #[Route('/products', name: 'product_list', methods: ['GET'])]
    public function list(
        QueryBusInterface $queryBus
    ): JsonResponse {
        $response = $queryBus->ask(new ListProductsQuery());

        return $this->json($response->products);
    }

    #[Route('/products/{id}', name: 'product_get', methods: ['GET'])]
    public function get(
        string $id,
        QueryBusInterface $queryBus,
    ): JsonResponse {
        $response = $queryBus->ask(new GetProductByIdQuery(ProductId::fromString($id)));

        return $this->json([
            'id' => $response->productDto->id,
            'name' => $response->productDto->name,
            'description' => $response->productDto->description,
            'price' => $response->productDto->price,
        ]);
    }
}
