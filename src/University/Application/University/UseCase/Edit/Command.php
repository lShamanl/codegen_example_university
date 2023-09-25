<?php

declare(strict_types=1);

namespace App\University\Application\University\UseCase\Edit;

use App\University\Domain\University\ValueObject\UniversityId;

readonly class Command
{
    public function __construct(
        public UniversityId $id,
        public ?string $description,
        public ?int $maxStudents,
        public ?string $name,
    ) {
    }
}
