<?php

declare(strict_types=1);

namespace App\Tests\Builder\University\Student;

use App\Tests\Builder\AbstractBuilder;
use App\Tests\Builder\University\University\UniversityBuilder;
use App\University\Domain\Student\Student;
use App\University\Domain\Student\ValueObject\StudentId;
use App\University\Domain\University\University;
use DateInterval;
use DateTimeImmutable;

class StudentBuilder extends AbstractBuilder
{
    protected StudentId $id;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    protected DateTimeImmutable $birthDay;

    protected string $firstName;

    protected string $lastName;

    protected string $middleName;

    protected University $university;

    public function build(): Student
    {
        /** @var Student $student */
        $student = self::create($this);

        return $student;
    }

    /** @return class-string<Student> */
    public static function getEntityClass(): string
    {
        return Student::class;
    }

    public static function randomPayload(object $entity): array
    {
        $payload = [];

        $payload['id'] = new StudentId((string) self::$faker->numberBetween(100000, 9999999));
        $payload['createdAt'] = (new DateTimeImmutable())->sub(new DateInterval('P' . random_int(180, 365) . 'D'));
        $payload['updatedAt'] = (new DateTimeImmutable())->sub(new DateInterval('P' . random_int(1, 179) . 'D'));
        $payload['birthDay'] = (new DateTimeImmutable(self::$faker->dateTime->format(DateTimeImmutable::ATOM)));
        $payload['firstName'] = self::$faker->text(255);
        $payload['lastName'] = self::$faker->text(255);
        $payload['middleName'] = self::$faker->text(255);
        $payload['university'] = (new UniversityBuilder())->build();

        return $payload;
    }

    public function withId(StudentId $id): self
    {
        $clone = clone $this;
        $clone->id = $id;

        return $clone;
    }

    public function withCreatedAt(DateTimeImmutable $createdAt): self
    {
        $clone = clone $this;
        $clone->createdAt = $createdAt;

        return $clone;
    }

    public function withUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $clone = clone $this;
        $clone->updatedAt = $updatedAt;

        return $clone;
    }

    public function withBirthDay(DateTimeImmutable $birthDay): self
    {
        $clone = clone $this;
        $clone->birthDay = $birthDay;

        return $clone;
    }

    public function withFirstName(string $firstName): self
    {
        $clone = clone $this;
        $clone->firstName = $firstName;

        return $clone;
    }

    public function withLastName(string $lastName): self
    {
        $clone = clone $this;
        $clone->lastName = $lastName;

        return $clone;
    }

    public function withMiddleName(string $middleName): self
    {
        $clone = clone $this;
        $clone->middleName = $middleName;

        return $clone;
    }

    public function withUniversity(University $university): self
    {
        $clone = clone $this;
        $clone->university = $university;

        return $clone;
    }
}
