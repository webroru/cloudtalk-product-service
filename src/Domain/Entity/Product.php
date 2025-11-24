<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Product implements ProductInterface
{
    private string $uuid;
    private string $name;
    private string $description;
    private float $price;

    public function __construct(string $id, string $name, ?string $description)
    {
        $this->uuid = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getAverage(): float
    {
        // TODO: Implement getAverage() method.
    }
}
