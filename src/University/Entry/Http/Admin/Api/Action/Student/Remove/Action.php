<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\Student\Remove;

use App\University\Application\Student\UseCase\Remove\Handler;
use App\University\Domain\Student\Student;
use App\University\Entry\Http\Admin\Api\Contract\Student\CommonOutputContract;
use IWD\Symfony\PresentationBundle\Dto\Input\OutputFormat;
use IWD\Symfony\PresentationBundle\Dto\Output\ApiFormatter;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    public const NAME = 'api_admin_app_university_student_remove';

    /**
     * @OA\Tag(name="University.Student")
     * @OA\Post(
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref=@Model(type=InputContract::class)
     *             )
     *         )
     *     )
     * )
     * @OA\Response(
     *     response=200,
     *     description="Remove command for Student",
     *     @OA\JsonContent(
     *         allOf={
     *             @OA\Schema(ref=@Model(type=ApiFormatter::class)),
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="data",
     *                     ref=@Model(type=CommonOutputContract::class)
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     example="200"
     *                 )
     *             )
     *         }
     *     )
     *  )
     * @OA\Response(
     *     response=400,
     *     description="Bad Request"
     * ),
     * @OA\Response(
     *     response=401,
     *     description="Unauthenticated",
     * ),
     * @OA\Response(
     *     response=403,
     *     description="Forbidden"
     * ),
     * @OA\Response(
     *     response=404,
     *     description="Resource Not Found"
     * )
     * @Security(name="Bearer")
     */
    #[Route(
        path: '/api/admin/university/students/remove.{_format}',
        name: self::NAME,
        defaults: ['_format' => 'json'],
        methods: ['POST'],
    )]
    public function action(
        InputContract $contract,
        CommandFactory $commandFactory,
        Handler $handler,
        OutputFormat $outputFormat,
        ResponsePresenter $responsePresenter,
        MetricSender $metricSender,
    ): Response {
        $command = $commandFactory->create($contract);
        $result = $handler->handle($command);
        $metricSender->send($result);

        return $responsePresenter->present($result, $outputFormat);
    }
}
