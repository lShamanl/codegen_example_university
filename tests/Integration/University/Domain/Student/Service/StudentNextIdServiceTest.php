<?php

declare(strict_types=1);

namespace App\Tests\Integration\University\Domain\Student\Service;

use App\Tests\Integration\IntegrationTestCase;
use App\University\Domain\Student\Service\StudentNextIdService;
use App\University\Domain\Student\ValueObject\StudentId;

/** @covers \App\University\Domain\Student\Service\StudentNextIdService */
class StudentNextIdServiceTest extends IntegrationTestCase
{
    protected static StudentNextIdService $studentNextIdService;

    public function setUp(): void
    {
        parent::setUp();
        self::$studentNextIdService = self::$containerTool->get(StudentNextIdService::class);
    }

    public function testAllocateId(): void
    {
        $id = self::$studentNextIdService->allocateId();

        self::assertInstanceOf(StudentId::class, $id);
        self::assertSame(
            (int) $id->getValue() + 1,
            (int) self::$studentNextIdService->allocateId()->getValue()
        );
    }
}
