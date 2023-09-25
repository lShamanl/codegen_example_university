<?php

declare(strict_types=1);

namespace App\University\Infrastructure\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Tools\ToolEvents;

/** @codeCoverageIgnore */
class FixSequenceSchemaSubscriber implements EventSubscriber
{
    /** {@inheritdoc} */
    public function getSubscribedEvents(): array
    {
        return [
            ToolEvents::postGenerateSchema,
        ];
    }

    /** @throws SchemaException */
    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $schema = $args->getSchema();

        $schema->createSequence('university_student_seq');
        $schema->createSequence('university_university_seq');
    }
}
