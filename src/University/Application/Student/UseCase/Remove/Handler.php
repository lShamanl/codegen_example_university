<?php

declare(strict_types=1);

namespace App\University\Application\Student\UseCase\Remove;

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

        $this->studentRepository->remove($student);
        $this->flusher->flush($student);

        return Result::success(
            student: $student,
            context: [
                'id' => $command->id->getValue(),
            ]
        );
    }
}
