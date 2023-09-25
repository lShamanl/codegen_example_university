<?php

declare(strict_types=1);

namespace App\University\Domain\Student;

use App\Common\Service\Core\AggregateRoot;
use App\Common\Service\Core\EventsTrait;
use App\University\Domain\Student\Type\StudentIdType;
use App\University\Domain\Student\ValueObject\StudentId;
use App\University\Domain\University\University;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\Table;
use Sylius\Component\Resource\Model\ResourceInterface;

/** Студенты. Приходят за новыми знаниями */
#[Table(name: 'university_students')]
#[Entity(repositoryClass: StudentRepository::class)]
#[HasLifecycleCallbacks]
class Student implements AggregateRoot, ResourceInterface
{
    use EventsTrait;

    /** ID entity property */
    #[Id]
    #[Column(
        type: StudentIdType::NAME,
        nullable: false,
    )]
    private StudentId $id;

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

    /** Дата рождения */
    #[Column(
        type: 'datetime_immutable',
        unique: false,
        nullable: false,
    )]
    private DateTimeImmutable $birthDay;

    /** Имя */
    #[Column(
        type: 'string',
        unique: false,
        nullable: false,
    )]
    private string $firstName;

    /** Фамилия */
    #[Column(
        type: 'string',
        unique: false,
        nullable: false,
    )]
    private string $lastName;

    /** Отчество */
    #[Column(
        type: 'string',
        unique: false,
        nullable: false,
    )]
    private string $middleName;

    #[ManyToOne(
        targetEntity: University::class,
        inversedBy: 'students',
    )]
    #[JoinColumn(
        name: 'university_id',
        referencedColumnName: 'id',
        nullable: false,
    )]
    private University $university;

    public function __construct(
        StudentId $id,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
        DateTimeImmutable $birthDay,
        string $firstName,
        string $lastName,
        string $middleName,
        University $university,
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->birthDay = $birthDay;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
        $this->university = $university;
    }

    public function edit(
        DateTimeImmutable $birthDay,
        string $firstName,
        string $lastName,
        string $middleName,
    ): void {
        $this->birthDay = $birthDay;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
    }

    public function getId(): StudentId
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

    public function getBirthDay(): DateTimeImmutable
    {
        return $this->birthDay;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function getUniversity(): University
    {
        return $this->university;
    }

    #[PreUpdate]
    public function onUpdated(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}
