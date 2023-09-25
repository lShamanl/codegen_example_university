<?php

declare(strict_types=1);

namespace App\University\Application\Student\UseCase\Create;

use App\University\Domain\Student\Student;

class Result
{
    public function __construct(
        public readonly ResultCase $case,
        public ?Student $student = null,
        public array $context = [],
    ) {
    }

    public static function success(
        Student $student,
        array $context = [],
    ): self {
        return new self(
            case: ResultCase::Success,
            student: $student,
            context: $context
        );
    }

    public function isSuccess(): bool
    {
        return $this->case->isEqual(ResultCase::Success);
    }

    public static function universityNotExists(array $context = []): self
    {
        return new self(case: ResultCase::UniversityNotExists, context: $context);
    }

    public function isUniversityNotExists(): bool
    {
        return $this->case->isEqual(ResultCase::UniversityNotExists);
    }
}
