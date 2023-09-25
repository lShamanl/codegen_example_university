<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\University\Remove;

use App\Common\Service\Metrics\AdapterInterface;
use App\University\Application\University\UseCase\Remove\Result;

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
        if ($result->isUniversityNotExists()) {
            $this->metrics->createCounter(
                name: str_replace('.', '_', Action::NAME) . ':university_not_exists',
                help: 'university not exists'
            )->inc();
        }
    }
}
