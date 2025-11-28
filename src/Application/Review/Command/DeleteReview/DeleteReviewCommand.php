<?php

declare(strict_types=1);

namespace App\Application\Review\Command\DeleteReview;

use App\Application\Shared\Bus\Command\CommandInterface;

final readonly class DeleteReviewCommand implements CommandInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
