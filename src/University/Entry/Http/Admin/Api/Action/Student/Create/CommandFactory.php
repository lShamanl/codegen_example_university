<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\Student\Create;

use App\University\Application\Student\UseCase\Create\Command;
use App\University\Domain\University\ValueObject\UniversityId;
use DateTimeImmutable;

class CommandFactory
{
    public function create(InputContract $inputContract): Command
    {
        if (!isset(
            $inputContract->birthDay,
            $inputContract->firstName,
            $inputContract->lastName,
            $inputContract->middleName,
        )) {
            throw new \Exception('Check NotNull asserts in ' . InputContract::class . ' for required properties');
        }

        return new Command(
            universityId: new UniversityId($inputContract->universityId),
            birthDay: new DateTimeImmutable($inputContract->birthDay),
            firstName: $inputContract->firstName,
            lastName: $inputContract->lastName,
            middleName: $inputContract->middleName,
        );
    }
}
