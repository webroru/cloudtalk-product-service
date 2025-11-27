<?php

declare(strict_types=1);

namespace App\Domain\Product\ValueObject;

use Symfony\Component\Uid\Uuid;

final class ProductId
{
    private Uuid $value;

    private function __construct(Uuid $value)
    {
        $this->value = $value;
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

    public function equals(ProductId $other): bool
    {
        return $this->value->equals($other->value);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
