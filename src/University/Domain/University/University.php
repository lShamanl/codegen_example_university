<?php

declare(strict_types=1);

namespace App\University\Domain\University;

use App\Common\Service\Core\AggregateRoot;
use App\Common\Service\Core\EventsTrait;
use App\University\Domain\Student\Student;
use App\University\Domain\University\Type\UniversityIdType;
use App\University\Domain\University\ValueObject\UniversityId;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Resource\Model\ResourceInterface;

/** Университет. Здесь учатся студенты */
#[Table(name: 'university_universities')]
#[Entity(repositoryClass: UniversityRepository::class)]
#[HasLifecycleCallbacks]
class University implements AggregateRoot, ResourceInterface
{
    use EventsTrait;

    /** ID entity property */
    #[Id]
    #[Column(
        type: UniversityIdType::NAME,
        nullable: false,
    )]
    private UniversityId $id;

    /** Created at entity stamp */
    #[Column(
        type: 'datetime_immutable',
        unique: false,
        nullable: false,
    )]
    private DateTimeImmutable $createdAt;

    /** Updated at entity stamp */
    #[Column(
        type: 'datetime_immutable',
        unique: false,
        nullable: false,
    )]
    private DateTimeImmutable $updatedAt;

    /** Описание института */
    #[Column(
        type: 'text',
        unique: false,
        nullable: false,
    )]
    private string $description;

    /** Максимальное количество студентов, которое университет может обучать одновременно */
    #[Column(
        type: 'integer',
        unique: false,
        nullable: false,
    )]
    private int $maxStudents;

    /** Название института */
    #[Column(
        type: 'string',
        unique: false,
        nullable: false,
    )]
    private string $name;

    /** @var Collection<int, Student> */
    #[OneToMany(
        mappedBy: 'university',
        targetEntity: Student::class,
        cascade: ['all'],
        orphanRemoval: true,
    )]
    private Collection $students;

    public function __construct(
        UniversityId $id,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
        string $description,
        int $maxStudents,
        string $name,
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->description = $description;
        $this->maxStudents = $maxStudents;
        $this->name = $name;
        $this->students = new ArrayCollection();
    }

    public function edit(
        string $description,
        int $maxStudents,
        string $name,
    ): void {
        $this->description = $description;
        $this->maxStudents = $maxStudents;
        $this->name = $name;
    }

    public function addStudent(Student $student): void
    {
        $this->students->add($student);
    }

    public function removeStudent(Student $student): void
    {
        $this->students->removeElement($student);
    }

    public function getId(): UniversityId
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMaxStudents(): int
    {
        return $this->maxStudents;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /** @return Student[] */
    public function getStudents(): array
    {
        return $this->students->toArray();
    }

    #[PreUpdate]
    public function onUpdated(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}
