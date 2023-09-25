<?php

declare(strict_types=1);

namespace App\Tests\Unit\University\Domain\University\ValueObject;

use App\Tests\Unit\UnitTestCase;
use App\University\Domain\University\ValueObject\UniversityId;

/** @covers \App\University\Domain\University\ValueObject\UniversityId */
class UniversityIdTest extends UnitTestCase
{
    public function testToString(): void
    {
        $value = (string) random_int(1, 999);
        self::assertSame($value, (new UniversityId($value))->__toString());
    }

    public function testGetValue(): void
    {
        $value = (string) random_int(1, 999);
        self::assertSame($value, (new UniversityId($value))->getValue());
    }
}
