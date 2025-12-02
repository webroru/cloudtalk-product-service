<?php

declare(strict_types=1);

namespace App\Application\Product\Service;

use Symfony\Contracts\Cache\CacheInterface;

final readonly class ProductRatingService
{
    public function __construct(
        private CacheInterface $cache,
    ) {
    }

    public function getRating(string $productId): float
    {
        $key = sprintf('product_rating_%s', $productId);

        $item = $this->cache->getItem($key);
        if (!$item->isHit()) {
            return 0.0;
        }

        $data = json_decode($item->get(), true, 512, JSON_THROW_ON_ERROR);

        return $data['averageRating'] ?? 0.0;
    }
}
