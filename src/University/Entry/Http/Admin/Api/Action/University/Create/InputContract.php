<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\University\Create;

use IWD\Symfony\PresentationBundle\Interfaces\InputContractInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class InputContract implements InputContractInterface
{
    #[NotNull]
    public ?string $description;

    #[NotNull]
    public ?int $maxStudents;

    #[NotNull]
    #[Length(max: 255)]
    public ?string $name;
}
