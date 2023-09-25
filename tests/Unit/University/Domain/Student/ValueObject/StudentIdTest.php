<?php

declare(strict_types=1);

namespace App\Tests\Unit\University\Domain\Student\ValueObject;

use App\Tests\Unit\UnitTestCase;
use App\University\Domain\Student\ValueObject\StudentId;

/** @covers \App\University\Domain\Student\ValueObject\StudentId */
class StudentIdTest extends UnitTestCase
{
    public function testToString(): void
    {
        $value = (string) random_int(1, 999);
        self::assertSame($value, (new StudentId($value))->__toString());
    }

    public function testGetValue(): void
    {
        $value = (string) random_int(1, 999);
        self::assertSame($value, (new StudentId($value))->getValue());
    }
}
