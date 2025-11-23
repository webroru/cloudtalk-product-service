<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Symfony\Component\Uid\Uuid;

interface ProductInterface
{
    public function getName(): Uuid;
    public function setName(): self;
    public function getDescription(): string;
    public function setDescription(): self;
    public function getPrice(): float;
    public function setPrice(): self;
    public function getAverage(): float;
    public function setAverage(): self;
}
