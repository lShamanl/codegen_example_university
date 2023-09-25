<?php

declare(strict_types=1);

namespace App\University\Application\Student\UseCase\Create;

use App\University\Domain\University\ValueObject\UniversityId;
use DateTimeImmutable;

readonly class Command
{
    public function __construct(
        public UniversityId $universityId,
        public DateTimeImmutable $birthDay,
        public string $firstName,
        public string $lastName,
        public string $middleName,
    ) {
    }
}
