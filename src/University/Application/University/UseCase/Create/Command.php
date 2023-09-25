<?php

declare(strict_types=1);

namespace App\University\Application\University\UseCase\Create;

readonly class Command
{
    public function __construct(
        public string $description,
        public int $maxStudents,
        public string $name,
    ) {
    }
}
