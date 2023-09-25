<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Contract\Student;

use App\University\Domain\Student\Student;
use DateTimeInterface;

class CommonOutputContract
{
    public string $birthDay;

    public string $createdAt;

    public string $firstName;

    public string $id;

    public string $lastName;

    public string $middleName;

    public string $updatedAt;

    public string $universityId;

    public static function create(Student $student): self
    {
        $contract = new self();
        $contract->birthDay = $student->getBirthDay()->format(DateTimeInterface::ATOM);
        $contract->createdAt = $student->getCreatedAt()->format(DateTimeInterface::ATOM);
        $contract->firstName = $student->getFirstName();
        $contract->id = $student->getId()->getValue();
        $contract->lastName = $student->getLastName();
        $contract->middleName = $student->getMiddleName();
        $contract->updatedAt = $student->getUpdatedAt()->format(DateTimeInterface::ATOM);
        $contract->universityId = $student->getUniversity()->getId()->getValue();

        return $contract;
    }
}
