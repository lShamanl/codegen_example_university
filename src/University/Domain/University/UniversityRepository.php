<?php

declare(strict_types=1);

namespace App\University\Domain\University;

use App\University\Domain\University\ValueObject\UniversityId;
use Doctrine\ORM\EntityManagerInterface;
use Generator;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Model\ResourceInterface;

class UniversityRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(University::class));
    }

    public function add(ResourceInterface $resource): void
    {
        $this->getEntityManager()->persist($resource);
    }

    public function remove(ResourceInterface $resource): void
    {
        $this->getEntityManager()->remove($resource);
    }

    public function findById(UniversityId $id): ?University
    {
        /** @var University|null $university */
        $university = $this->findOneBy(['id' => $id]);

        return $university;
    }

    public function hasById(UniversityId $id): bool
    {
        return null !== $this->findOneBy(['id' => $id]);
    }

    public function all(
        int $size = 100,
        int $offset = 0,
    ): Generator {
        $count = $this->createQueryBuilder('university')->select('count(1)')
            ->getQuery()
            ->getSingleScalarResult();

        while ($offset < $count) {
            /** @var University[] $universities */
            $universities = $this->createQueryBuilder('university')
                ->addOrderBy('university.id', 'ASC')
                ->setFirstResult($offset)
                ->setMaxResults($size)
                ->getQuery()
                ->getResult()
            ;
            foreach ($universities as $university) {
                yield $university;
            }

            $offset += $size;
            $this->getEntityManager()->clear();
        }
    }
}
