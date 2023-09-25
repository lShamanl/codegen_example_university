<?php

declare(strict_types=1);

namespace App\University\Domain\Student\Type;

use App\University\Domain\Student\ValueObject\StudentId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\BigIntType;

class StudentIdType extends BigIntType
{
    public const NAME = 'university_student_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToDatabaseValue(
        mixed $value,
        AbstractPlatform $platform,
    ): ?string {
        return $value instanceof StudentId ? $value->__toString() : $value;
    }

    /**
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress NullableReturnStatement
     */
    public function convertToPHPValue(
        mixed $value,
        AbstractPlatform $platform,
    ): ?StudentId {
        return !empty($value) ? new StudentId((string) $value) : null;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
