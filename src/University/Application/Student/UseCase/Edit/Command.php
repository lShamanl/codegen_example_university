<?php

declare(strict_types=1);

namespace App\University\Application\Student\UseCase\Edit;

use App\University\Domain\Student\ValueObject\StudentId;
use DateTimeImmutable;

readonly class Command
{
    public function __construct(
        public StudentId $id,
        public ?DateTimeImmutable $birthDay,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $middleName,
    ) {
    }
}
