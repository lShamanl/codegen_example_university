<?php

declare(strict_types=1);

namespace App\University\Domain\University\Service;

use App\University\Domain\University\ValueObject\UniversityId;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class UniversityNextIdService
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    /** @throws Exception */
    public function allocateId(): UniversityId
    {
        $id = $this->em
            ->getConnection()
            ->prepare("SELECT nextval('university_university_seq')")
            ->executeQuery()
            ->fetchOne();

        return new UniversityId((string) $id);
    }
}
