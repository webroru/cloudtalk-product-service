<?php

declare(strict_types=1);

use App\Infrastructure\Doctrine\Type\ProductIdType;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);

$builder->setTable('products');

$builder
    ->createField('id', ProductIdType::class)
    ->makePrimaryKey()
    ->build();

$builder
    ->createField('name', 'string')
    ->length(255)
    ->build();

$builder
    ->createField('description', 'string')
    ->length(255)
    ->nullable()
    ->build();

$builder
    ->createField('price', 'float')
    ->build();
