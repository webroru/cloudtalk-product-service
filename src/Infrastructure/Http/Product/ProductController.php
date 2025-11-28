<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Product;

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
}
