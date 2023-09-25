<?php

declare(strict_types=1);

namespace App\University\Application\Student\UseCase\Remove;

enum ResultCase
{
    case Success;
    case StudentNotExists;

    public function isEqual(self $enum): bool
    {
        return $this->name === $enum->name;
    }
}
