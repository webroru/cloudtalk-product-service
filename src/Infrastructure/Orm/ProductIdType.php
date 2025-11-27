<?php

declare(strict_types=1);

namespace App\Infrastructure\Orm;

use App\Domain\Product\ValueObject\ProductId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class ProductIdType extends GuidType
{
    public function getName() : string
    {
        return self::class;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) : ProductId
    {
        return ProductId::fromString($value);
    }

    /**
     * @param ProductId $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) : ?string
    {
        return $value?->toString();
    }
}
