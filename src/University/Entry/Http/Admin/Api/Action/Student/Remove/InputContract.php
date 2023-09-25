<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\Student\Remove;

use IWD\Symfony\PresentationBundle\Interfaces\InputContractInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

class InputContract implements InputContractInterface
{
    #[NotNull]
    #[Positive]
    public ?string $id;
}
