<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Review\ValueObject\ReviewId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class ReviewIdType extends GuidType
{
    public function getName(): string
    {
        return self::class;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ReviewId
    {
        return ReviewId::fromString($value);
    }

    /**
     * @param ReviewId $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->toString();
    }
}
