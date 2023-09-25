<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\University\Edit;

use App\University\Application\University\UseCase\Edit\Command;
use App\University\Domain\University\ValueObject\UniversityId;

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
            description: null !== $inputContract->description ? $inputContract->description : null,
            id: new UniversityId($inputContract->id),
            maxStudents: null !== $inputContract->maxStudents ? $inputContract->maxStudents : null,
            name: null !== $inputContract->name ? $inputContract->name : null,
        );
    }
}
