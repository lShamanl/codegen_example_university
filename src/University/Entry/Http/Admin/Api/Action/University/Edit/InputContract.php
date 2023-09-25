<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\University\Edit;

use IWD\Symfony\PresentationBundle\Interfaces\InputContractInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

class InputContract implements InputContractInterface
{
    public ?string $description = null;

    #[NotNull]
    #[Positive]
    public ?string $id;

    public ?int $maxStudents = null;

    #[Length(max: 255)]
    public ?string $name = null;
}
