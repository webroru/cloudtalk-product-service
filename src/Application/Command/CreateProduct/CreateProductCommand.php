<?php

declare(strict_types=1);

namespace App\Application\Command\CreateProduct;

use App\Domain\Bus\Command\CommandInterface;

readonly class CreateProductCommand implements CommandInterface
{
    public function __construct(
        private string $name,
        private string $description,
        private float $price,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function price(): float
    {
        return $this->price;
    }
}
