<?php

declare(strict_types=1);

namespace App\University\Domain\University\Type;

use App\University\Domain\University\ValueObject\UniversityId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\BigIntType;

class UniversityIdType extends BigIntType
{
    public const NAME = 'university_university_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToDatabaseValue(
        mixed $value,
        AbstractPlatform $platform,
    ): ?string {
        return $value instanceof UniversityId ? $value->__toString() : $value;
    }

    /**
     * @psalm-suppress InvalidNullableReturnType
     * @psalm-suppress NullableReturnStatement
     */
    public function convertToPHPValue(
        mixed $value,
        AbstractPlatform $platform,
    ): ?UniversityId {
        return !empty($value) ? new UniversityId((string) $value) : null;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
