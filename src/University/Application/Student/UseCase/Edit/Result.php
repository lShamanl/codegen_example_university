<?php

declare(strict_types=1);

namespace App\University\Application\Student\UseCase\Edit;

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

    public static function studentNotExists(array $context = []): self
    {
        return new self(case: ResultCase::StudentNotExists, context: $context);
    }

    public function isStudentNotExists(): bool
    {
        return $this->case->isEqual(ResultCase::StudentNotExists);
    }
}
