<?php

declare(strict_types=1);

namespace App\University\Application\University\UseCase\Create;

use App\Common\Service\Core\Flusher;
use App\University\Domain\University\Service\UniversityNextIdService;
use App\University\Domain\University\University;
use App\University\Domain\University\UniversityRepository;
use DateTimeImmutable;

readonly class Handler
{
    public function __construct(
        private Flusher $flusher,
        private UniversityRepository $universityRepository,
        private UniversityNextIdService $universityNextIdService,
    ) {
    }

    public function handle(Command $command): Result
    {
        $now = new DateTimeImmutable();
        $university = new University(
            id: $this->universityNextIdService->allocateId(),
            createdAt: $now,
            updatedAt: $now,
            description: $command->description,
            maxStudents: $command->maxStudents,
            name: $command->name
        );

        $this->universityRepository->add($university);
        $this->flusher->flush($university);

        return Result::success(
            university: $university,
            context: [
                'id' => $university->getId()->getValue(),
            ]
        );
    }
}
