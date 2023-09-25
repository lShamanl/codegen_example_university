<?php

declare(strict_types=1);

namespace App\University\Application\University\UseCase\Remove;

use App\Common\Service\Core\Flusher;
use App\University\Domain\University\UniversityRepository;

readonly class Handler
{
    public function __construct(
        private Flusher $flusher,
        private UniversityRepository $universityRepository,
    ) {
    }

    public function handle(Command $command): Result
    {
        $university = $this->universityRepository->findById($command->id);
        if (null === $university) {
            return Result::universityNotExists();
        }

        $this->universityRepository->remove($university);
        $this->flusher->flush($university);

        return Result::success(
            university: $university,
            context: [
                'id' => $command->id->getValue(),
            ]
        );
    }
}
