<?php

declare(strict_types=1);

namespace App\Tests\Integration\University\Domain\University\Service;

use App\Tests\Integration\IntegrationTestCase;
use App\University\Domain\University\Service\UniversityNextIdService;
use App\University\Domain\University\ValueObject\UniversityId;

/** @covers \App\University\Domain\University\Service\UniversityNextIdService */
class UniversityNextIdServiceTest extends IntegrationTestCase
{
    protected static UniversityNextIdService $universityNextIdService;

    public function setUp(): void
    {
        parent::setUp();
        self::$universityNextIdService = self::$containerTool->get(UniversityNextIdService::class);
    }

    public function testAllocateId(): void
    {
        $id = self::$universityNextIdService->allocateId();

        self::assertInstanceOf(UniversityId::class, $id);
        self::assertSame(
            (int) $id->getValue() + 1,
            (int) self::$universityNextIdService->allocateId()->getValue()
        );
    }
}
