<?php

declare(strict_types=1);

namespace App\University\Domain\Student\Service;

use App\University\Domain\Student\ValueObject\StudentId;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class StudentNextIdService
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /** @throws Exception */
    public function allocateId(): StudentId
    {
        $id = $this->em
            ->getConnection()
            ->prepare("SELECT nextval('university_student_seq')")
            ->executeQuery()
            ->fetchOne();

        return new StudentId((string) $id);
    }
}
