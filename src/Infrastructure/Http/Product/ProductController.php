<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Product;

use App\Domain\Product\ValueObject\ProductId;
use App\Infrastructure\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    public function __construct(private readonly ProductService $productService) {}

    #[Route('/products', name: 'product_create', methods: ['POST'])]
    public function create(
        Request $request,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $this->productService->createProduct(
            $data['name'],
            $data['description'],
            $data['price']
        );

        return new JsonResponse(['status' => 'ok'], 201);
    }

    #[Route('/products/{id}', name: 'product_update', methods: ['PUT'])]
    public function update(
        string $id,
        Request $request,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $this->productService->updateProduct(
            id: ProductId::fromString($id),
            name: $data['name'],
            description: $data['description'] ?? null,
            price: (float)$data['price'],
        );

        return $this->json(['status' => 'ok']);
    }

    #[Route('/products/{id}', name: 'product_delete', methods: ['DELETE'])]
    public function delete(
        string $id,
    ): JsonResponse {
        $this->productService->deleteProduct(
            id: ProductId::fromString($id)
        );

        return $this->json(['status' => 'deleted']);
    }

    #[Route('/products/{id}', name: 'product_get', methods: ['GET'])]
    public function get(
        string $id,
    ): JsonResponse {
        return $this->json($this->productService->getProduct(ProductId::fromString($id)));
    }

    #[Route('/products', name: 'product_list', methods: ['GET'])]
    public function list(
    ): JsonResponse {
        return $this->json($this->productService->listProducts());
    }
}
