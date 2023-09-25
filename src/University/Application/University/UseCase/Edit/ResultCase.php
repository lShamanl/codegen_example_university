<?php

declare(strict_types=1);

namespace App\University\Application\University\UseCase\Edit;

enum ResultCase
{
    case Success;
    case UniversityNotExists;

    public function isEqual(self $enum): bool
    {
        return $this->name === $enum->name;
    }
}
