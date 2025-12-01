<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Review\ValueObject\Rating;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class RatingType extends Type
{
    public function getName(): string
    {
        return self::class;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Rating
    {
        if ($value === null) {
            return null;
        }

        return new Rating((int) $value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if ($value === null) {
            return null;
        }

        if (!$value instanceof Rating) {
            throw new \InvalidArgumentException(sprintf(
                'Expected %s, got %s',
                Rating::class,
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        return $value->getValue();
    }
}
