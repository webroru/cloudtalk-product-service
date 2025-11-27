<?php

declare(strict_types=1);

namespace App\Domain\Review\ValueObject;

use Symfony\Component\Uid\Uuid;

final readonly class ReviewId
{
    private function __construct(private Uuid $value)
    {
    }

    public static function fromString(string $id): self
    {
        return new self(Uuid::fromString($id));
    }

    public static function generate(): self
    {
        return new self(Uuid::v7());
    }

    public function value(): Uuid
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->value->toRfc4122();
    }

    public function equals(ReviewId $other): bool
    {
        return $this->value->equals($other->value);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
