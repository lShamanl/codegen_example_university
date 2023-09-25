<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\Student\Edit;

use App\Common\Service\Metrics\AdapterInterface;
use App\University\Application\Student\UseCase\Edit\Result;

/** @codeCoverageIgnore */
class MetricSender
{
    public function __construct(private readonly AdapterInterface $metrics)
    {
    }

    public function send(Result $result): void
    {
        if ($result->isSuccess()) {
            $this->metrics->createCounter(
                name: str_replace('.', '_', Action::NAME) . ':success',
                help: 'success'
            )->inc();
        }
        if ($result->isStudentNotExists()) {
            $this->metrics->createCounter(
                name: str_replace('.', '_', Action::NAME) . ':student_not_exists',
                help: 'student not exists'
            )->inc();
        }
    }
}
