<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\University\Remove;

use App\University\Application\University\UseCase\Remove\Command;
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
            id: new UniversityId($inputContract->id),
        );
    }
}
