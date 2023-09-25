<?php

declare(strict_types=1);

namespace App\Tests\Unit\University\Domain\Student\Type;

use App\Tests\Unit\UnitTestCase;
use App\University\Domain\Student\Type\StudentIdType;
use App\University\Domain\Student\ValueObject\StudentId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/** @covers \App\University\Domain\Student\Type\StudentIdType */
class StudentIdTypeTest extends UnitTestCase
{
    public function testConvertToPHPValueSuccess(): void
    {
        /** @psalm-suppress InternalMethod */
        $idType = new StudentIdType();
        $abstractPlatformMock = $this->createMock(AbstractPlatform::class);
        $value = '163';

        /** @var StudentId|null $phpValue */
        $phpValue = $idType->convertToPHPValue($value, $abstractPlatformMock);

        self::assertSame($value, $phpValue?->getValue());
        self::assertInstanceOf(StudentId::class, $phpValue);
    }

    public function testConvertToPHPValueWithEmptyValue(): void
    {
        /** @psalm-suppress InternalMethod */
        $idType = new StudentIdType();
        $abstractPlatformMock = $this->createMock(AbstractPlatform::class);

        self::assertNull(
            $idType->convertToPHPValue(null, $abstractPlatformMock)
        );
    }

    public function testConvertToDatabaseValueSuccess(): void
    {
        /** @psalm-suppress InternalMethod */
        $idType = new StudentIdType();
        $abstractPlatformMock = $this->createMock(AbstractPlatform::class);
        $value = new StudentId('592');

        $convertedDatabaseValue = $idType->convertToDatabaseValue($value, $abstractPlatformMock);
        self::assertSame($value->getValue(), $convertedDatabaseValue);
    }

    public function testConvertToDatabaseValueWithEmptyValue(): void
    {
        /** @psalm-suppress InternalMethod */
        $idType = new StudentIdType();
        $abstractPlatformMock = $this->createMock(AbstractPlatform::class);

        self::assertNull(
            $idType->convertToDatabaseValue(null, $abstractPlatformMock)
        );
    }

    public function testGetName(): void
    {
        /** @psalm-suppress InternalMethod */
        $idType = new StudentIdType();
        self::assertSame(StudentIdType::NAME, $idType->getName());
    }

    public function testRequiresSQLCommentHint(): void
    {
        /** @psalm-suppress InternalMethod */
        $idType = new StudentIdType();
        $abstractPlatformMock = $this->createMock(AbstractPlatform::class);
        self::assertTrue(
            $idType->requiresSQLCommentHint($abstractPlatformMock)
        );
    }
}
