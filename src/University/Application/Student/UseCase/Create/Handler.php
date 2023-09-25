<?php

declare(strict_types=1);

namespace App\University\Application\Student\UseCase\Create;

use App\Common\Service\Core\Flusher;
use App\University\Domain\Student\Service\StudentNextIdService;
use App\University\Domain\Student\Student;
use App\University\Domain\Student\StudentRepository;
use App\University\Domain\University\UniversityRepository;
use DateTimeImmutable;

readonly class Handler
{
    public function __construct(
        private Flusher $flusher,
        private StudentRepository $studentRepository,
        private StudentNextIdService $studentNextIdService,
        private UniversityRepository $universityRepository,
    ) {
    }

    public function handle(Command $command): Result
    {
        $university = $this->universityRepository->findById($command->universityId);
        if (null === $university) {
            return Result::universityNotExists();
        }
        $now = new DateTimeImmutable();
        $student = new Student(
            id: $this->studentNextIdService->allocateId(),
            createdAt: $now,
            updatedAt: $now,
            birthDay: $command->birthDay,
            firstName: $command->firstName,
            lastName: $command->lastName,
            middleName: $command->middleName,
            university: $university
        );

        $this->studentRepository->add($student);
        $this->flusher->flush($student);

        return Result::success(
            student: $student,
            context: [
                'id' => $student->getId()->getValue(),
            ]
        );
    }
}
