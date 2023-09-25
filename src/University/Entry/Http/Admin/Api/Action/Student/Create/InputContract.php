<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\Student\Create;

use IWD\Symfony\PresentationBundle\Interfaces\InputContractInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

class InputContract implements InputContractInterface
{
    #[NotNull]
    #[Positive]
    public string $universityId;

    #[NotNull]
    public ?string $birthDay;

    #[NotNull]
    #[Length(max: 255)]
    public ?string $firstName;

    #[NotNull]
    #[Length(max: 255)]
    public ?string $lastName;

    #[NotNull]
    #[Length(max: 255)]
    public ?string $middleName;
}
