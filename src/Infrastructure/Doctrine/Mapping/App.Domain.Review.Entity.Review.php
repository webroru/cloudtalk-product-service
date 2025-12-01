<?php

declare(strict_types=1);

use App\Infrastructure\Doctrine\Type\ProductIdType;
use App\Infrastructure\Doctrine\Type\RatingType;
use App\Infrastructure\Doctrine\Type\ReviewIdType;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);

$builder->setTable('reviews');

$builder
    ->createField('id', ReviewIdType::class)
    ->makePrimaryKey()
    ->build();

$builder
    ->createField('productId', ProductIdType::class)
    ->build();

$builder
    ->createField('firstName', 'string')
    ->length(100)
    ->build();

$builder
    ->createField('lastName', 'string')
    ->length(100)
    ->build();

$builder
    ->createField('text', 'text')
    ->build();

$builder
    ->createField('rating', RatingType::class)
    ->build();
