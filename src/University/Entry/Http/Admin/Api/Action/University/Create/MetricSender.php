<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\University\Create;

use App\Common\Service\Metrics\AdapterInterface;
use App\University\Application\University\UseCase\Create\Result;

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
    }
}
