<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\Student\Edit;

use IWD\Symfony\PresentationBundle\Interfaces\InputContractInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

class InputContract implements InputContractInterface
{
    public ?string $birthDay = null;

    #[Length(max: 255)]
    public ?string $firstName = null;

    #[NotNull]
    #[Positive]
    public ?string $id;

    #[Length(max: 255)]
    public ?string $lastName = null;

    #[Length(max: 255)]
    public ?string $middleName = null;
}
