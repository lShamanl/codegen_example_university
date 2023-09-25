<?php

declare(strict_types=1);

namespace App\University\Application\Student\UseCase\Remove;

use App\University\Domain\Student\ValueObject\StudentId;

readonly class Command
{
    public function __construct(public StudentId $id)
    {
    }
}
