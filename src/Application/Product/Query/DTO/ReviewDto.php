<?php

declare(strict_types=1);

namespace App\Application\Product\Query\DTO;

final readonly class ReviewDto
{
    public function __construct(
        public string $id,
        public string $firstName,
        public string $lastName,
        public string $text,
        public int $rating,
    ) {
    }
}
