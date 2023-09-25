<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\Student\Edit;

use App\University\Application\Student\UseCase\Edit\Command;
use App\University\Domain\Student\ValueObject\StudentId;
use DateTimeImmutable;

class CommandFactory
{
    public function create(InputContract $inputContract): Command
    {
        if (!isset(
            $inputContract->id,
        )) {
            throw new \Exception('Check NotNull asserts in ' . InputContract::class . ' for required properties');
        }

        return new Command(
            birthDay: null !== $inputContract->birthDay ? new DateTimeImmutable($inputContract->birthDay) : null,
            firstName: null !== $inputContract->firstName ? $inputContract->firstName : null,
            id: new StudentId($inputContract->id),
            lastName: null !== $inputContract->lastName ? $inputContract->lastName : null,
            middleName: null !== $inputContract->middleName ? $inputContract->middleName : null,
        );
    }
}
