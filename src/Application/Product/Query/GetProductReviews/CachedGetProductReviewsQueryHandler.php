<?php

declare(strict_types=1);

namespace App\Application\Product\Query\GetProductReviews;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final readonly class CachedGetProductReviewsQueryHandler
{
    public function __construct(
        private GetProductReviewsQueryHandler $inner,
        private CacheInterface $cache,
    ) {
    }

    public function __invoke(GetProductReviewsQuery $query): GetProductReviewsResponse
    {
        $key = sprintf('product_reviews_%s', $query->productId);

        return $this->cache->get($key, function (ItemInterface $item) use ($query) {
            $item->expiresAfter(3600);
            return ($this->inner)($query);
        });
    }
}
