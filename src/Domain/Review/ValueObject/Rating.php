<?php

declare(strict_types=1);

namespace App\Domain\Review\ValueObject;

final readonly class Rating
{
    public function __construct(
        private int $value
    ) {
        if ($value < 1 || $value > 5) {
            throw new \InvalidArgumentException('Rating must be between 1 and 5.');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
