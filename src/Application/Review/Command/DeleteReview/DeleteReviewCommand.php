<?php

declare(strict_types=1);

namespace App\Application\Review\Command\DeleteReview;

use App\Application\Shared\Bus\Command\CommandInterface;
use App\Domain\Review\ValueObject\ReviewId;

final readonly class DeleteReviewCommand implements CommandInterface
{
    public function __construct(
        public ReviewId $id,
    ) {
    }
}
