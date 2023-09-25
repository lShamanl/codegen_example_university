<?php

declare(strict_types=1);

namespace App\University\Domain\Student;

use App\University\Domain\Student\ValueObject\StudentId;
use Doctrine\ORM\EntityManagerInterface;
use Generator;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Model\ResourceInterface;

class StudentRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Student::class));
    }

    public function add(ResourceInterface $resource): void
    {
        $this->getEntityManager()->persist($resource);
    }

    public function remove(ResourceInterface $resource): void
    {
        $this->getEntityManager()->remove($resource);
    }

    public function findById(StudentId $id): ?Student
    {
        /** @var Student|null $student */
        $student = $this->findOneBy(['id' => $id]);

        return $student;
    }

    public function hasById(StudentId $id): bool
    {
        return null !== $this->findOneBy(['id' => $id]);
    }

    public function all(
        int $size = 100,
        int $offset = 0,
    ): Generator {
        $count = $this->createQueryBuilder('student')->select('count(1)')
            ->getQuery()
            ->getSingleScalarResult();

        while ($offset < $count) {
            /** @var Student[] $students */
            $students = $this->createQueryBuilder('student')
                ->addOrderBy('student.id', 'ASC')
                ->setFirstResult($offset)
                ->setMaxResults($size)
                ->getQuery()
                ->getResult()
            ;
            foreach ($students as $student) {
                yield $student;
            }

            $offset += $size;
            $this->getEntityManager()->clear();
        }
    }
}
