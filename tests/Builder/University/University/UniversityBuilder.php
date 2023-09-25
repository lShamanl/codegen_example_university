<?php

declare(strict_types=1);

namespace App\Tests\Builder\University\University;

use App\Tests\Builder\AbstractBuilder;
use App\University\Domain\University\University;
use App\University\Domain\University\ValueObject\UniversityId;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class UniversityBuilder extends AbstractBuilder
{
    protected UniversityId $id;

    protected DateTimeImmutable $createdAt;

    protected DateTimeImmutable $updatedAt;

    protected string $description;

    protected int $maxStudents;

    protected string $name;

    protected Collection $students;

    public function build(): University
    {
        /** @var University $university */
        $university = self::create($this);

        return $university;
    }

    /** @return class-string<University> */
    public static function getEntityClass(): string
    {
        return University::class;
    }

    public static function randomPayload(object $entity): array
    {
        $payload = [];

        $payload['id'] = new UniversityId((string) self::$faker->numberBetween(100000, 9999999));
        $payload['createdAt'] = (new DateTimeImmutable())->sub(new DateInterval('P' . random_int(180, 365) . 'D'));
        $payload['updatedAt'] = (new DateTimeImmutable())->sub(new DateInterval('P' . random_int(1, 179) . 'D'));
        $payload['description'] = self::$faker->text(511);
        $payload['maxStudents'] = self::$faker->numberBetween(1);
        $payload['name'] = self::$faker->text(255);
        $payload['students'] = new ArrayCollection();

        return $payload;
    }

    public function withId(UniversityId $id): self
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

    public function withDescription(string $description): self
    {
        $clone = clone $this;
        $clone->description = $description;

        return $clone;
    }

    public function withMaxStudents(int $maxStudents): self
    {
        $clone = clone $this;
        $clone->maxStudents = $maxStudents;

        return $clone;
    }

    public function withName(string $name): self
    {
        $clone = clone $this;
        $clone->name = $name;

        return $clone;
    }

    public function withStudents(Collection $students): self
    {
        $clone = clone $this;
        $clone->students = $students;

        return $clone;
    }
}
