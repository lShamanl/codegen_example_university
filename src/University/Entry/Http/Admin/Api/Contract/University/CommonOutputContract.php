<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Contract\University;

use App\University\Domain\University\University;
use DateTimeInterface;

class CommonOutputContract
{
    public string $createdAt;

    public string $description;

    public string $id;

    public int $maxStudents;

    public string $name;

    public string $updatedAt;

    public static function create(University $university): self
    {
        $contract = new self();
        $contract->createdAt = $university->getCreatedAt()->format(DateTimeInterface::ATOM);
        $contract->description = $university->getDescription();
        $contract->id = $university->getId()->getValue();
        $contract->maxStudents = $university->getMaxStudents();
        $contract->name = $university->getName();
        $contract->updatedAt = $university->getUpdatedAt()->format(DateTimeInterface::ATOM);

        return $contract;
    }
}
