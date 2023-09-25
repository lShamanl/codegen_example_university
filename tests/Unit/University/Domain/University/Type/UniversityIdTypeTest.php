<?php

declare(strict_types=1);

namespace App\Tests\Unit\University\Domain\University\Type;

use App\Tests\Unit\UnitTestCase;
use App\University\Domain\University\Type\UniversityIdType;
use App\University\Domain\University\ValueObject\UniversityId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/** @covers \App\University\Domain\University\Type\UniversityIdType */
class UniversityIdTypeTest extends UnitTestCase
{
    public function testConvertToPHPValueSuccess(): void
    {
        /** @psalm-suppress InternalMethod */
        $idType = new UniversityIdType();
        $abstractPlatformMock = $this->createMock(AbstractPlatform::class);
        $value = '400';

        /** @var UniversityId|null $phpValue */
        $phpValue = $idType->convertToPHPValue($value, $abstractPlatformMock);

        self::assertSame($value, $phpValue?->getValue());
        self::assertInstanceOf(UniversityId::class, $phpValue);
    }

    public function testConvertToPHPValueWithEmptyValue(): void
    {
        /** @psalm-suppress InternalMethod */
        $idType = new UniversityIdType();
        $abstractPlatformMock = $this->createMock(AbstractPlatform::class);

        self::assertNull(
            $idType->convertToPHPValue(null, $abstractPlatformMock)
        );
    }

    public function testConvertToDatabaseValueSuccess(): void
    {
        /** @psalm-suppress InternalMethod */
        $idType = new UniversityIdType();
        $abstractPlatformMock = $this->createMock(AbstractPlatform::class);
        $value = new UniversityId('8');

        $convertedDatabaseValue = $idType->convertToDatabaseValue($value, $abstractPlatformMock);
        self::assertSame($value->getValue(), $convertedDatabaseValue);
    }

    public function testConvertToDatabaseValueWithEmptyValue(): void
    {
        /** @psalm-suppress InternalMethod */
        $idType = new UniversityIdType();
        $abstractPlatformMock = $this->createMock(AbstractPlatform::class);

        self::assertNull(
            $idType->convertToDatabaseValue(null, $abstractPlatformMock)
        );
    }

    public function testGetName(): void
    {
        /** @psalm-suppress InternalMethod */
        $idType = new UniversityIdType();
        self::assertSame(UniversityIdType::NAME, $idType->getName());
    }

    public function testRequiresSQLCommentHint(): void
    {
        /** @psalm-suppress InternalMethod */
        $idType = new UniversityIdType();
        $abstractPlatformMock = $this->createMock(AbstractPlatform::class);
        self::assertTrue(
            $idType->requiresSQLCommentHint($abstractPlatformMock)
        );
    }
}
