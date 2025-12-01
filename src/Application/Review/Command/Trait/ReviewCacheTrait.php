<?php

declare(strict_types=1);

namespace App\Application\Review\Command\Trait;

trait ReviewCacheTrait
{
    private function clearCacheForProduct(string $productId): void
    {
        $this->cache->delete(sprintf('product_reviews_%s', $productId));
    }
}
