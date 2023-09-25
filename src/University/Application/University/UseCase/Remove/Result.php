<?php

declare(strict_types=1);

namespace App\University\Application\University\UseCase\Remove;

use App\University\Domain\University\University;

class Result
{
    public function __construct(
        public readonly ResultCase $case,
        public ?University $university = null,
        public array $context = [],
    ) {
    }

    public static function success(
        University $university,
        array $context = [],
    ): self {
        return new self(
            case: ResultCase::Success,
            university: $university,
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
