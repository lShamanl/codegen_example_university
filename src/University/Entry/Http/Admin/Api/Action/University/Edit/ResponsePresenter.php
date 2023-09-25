<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\University\Edit;

use App\University\Application\University\UseCase\Edit\Result;
use App\University\Entry\Http\Admin\Api\Contract\University\CommonOutputContract;
use DomainException;
use IWD\Symfony\PresentationBundle\Dto\Input\OutputFormat;
use IWD\Symfony\PresentationBundle\Dto\Output\ApiFormatter;
use IWD\Symfony\PresentationBundle\Service\Presenter;
use Symfony\Component\HttpFoundation\Response;

class ResponsePresenter
{
    public function __construct(private readonly Presenter $presenter)
    {
    }

    public function present(
        Result $result,
        OutputFormat $outputFormat,
    ): Response {
        if ($result->isSuccess()) {
            return $this->presenter->present(
                data: ApiFormatter::prepare(
                    data: null !== $result->university ? CommonOutputContract::create($result->university) : null,
                    messages: ['success']
                ),
                outputFormat: $outputFormat,
                status: Response::HTTP_OK,
            );
        }
        if ($result->isUniversityNotExists()) {
            return $this->presenter->present(
                data: ApiFormatter::prepare(
                    data: null !== $result->university ? CommonOutputContract::create($result->university) : null,
                    messages: ['university not exists']
                ),
                outputFormat: $outputFormat,
                status: Response::HTTP_BAD_REQUEST,
            );
        }

        throw new DomainException('Unexpected termination of the script');
    }
}
