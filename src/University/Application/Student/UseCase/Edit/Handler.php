<?php

declare(strict_types=1);

namespace App\University\Application\Student\UseCase\Edit;

use App\Common\Service\Core\Flusher;
use App\University\Domain\Student\StudentRepository;

readonly class Handler
{
    public function __construct(
        private Flusher $flusher,
        private StudentRepository $studentRepository,
    ) {
    }

    public function handle(Command $command): Result
    {
        $student = $this->studentRepository->findById($command->id);
        if (null === $student) {
            return Result::studentNotExists();
        }

        $birthDay = $command->birthDay ?? $student->getBirthDay();
        $firstName = $command->firstName ?? $student->getFirstName();
        $lastName = $command->lastName ?? $student->getLastName();
        $middleName = $command->middleName ?? $student->getMiddleName();
        $student->edit(
            birthDay: $birthDay,
            firstName: $firstName,
            lastName: $lastName,
            middleName: $middleName
        );

        $this->flusher->flush($student);

        return Result::success(
            student: $student,
            context: [
                'id' => $command->id->getValue(),
            ]
        );
    }
}
