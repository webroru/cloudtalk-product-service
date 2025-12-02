<?php

declare(strict_types=1);

namespace App\Application\Product\Service;

final readonly class ProductRatingService
{
    public function __construct(
        private \Redis $redis,
    ) {
    }

    public function getRating(string $productId): float
    {
        $key = sprintf('product_rating_%s', $productId);
        if (!$this->redis->exists($key)) {
            return 0.0;
        }
        $json = $this->redis->get($key);
        $data = json_decode($json, true) ?? 0.0;

        return $data['averageRating'] ?? 0.0;
    }
}
