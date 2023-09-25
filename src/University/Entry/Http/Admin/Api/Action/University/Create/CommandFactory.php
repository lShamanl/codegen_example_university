<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\University\Create;

use App\University\Application\University\UseCase\Create\Command;

class CommandFactory
{
    public function create(InputContract $inputContract): Command
    {
        if (!isset(
            $inputContract->description,
            $inputContract->maxStudents,
            $inputContract->name,
        )) {
            throw new \Exception('Check NotNull asserts in ' . InputContract::class . ' for required properties');
        }

        return new Command(
            description: $inputContract->description,
            maxStudents: $inputContract->maxStudents,
            name: $inputContract->name,
        );
    }
}
