<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\Student\Read;

use App\University\Domain\Student\Student;
use App\University\Entry\Http\Admin\Api\Contract\Student\CommonOutputContract;
use IWD\Symfony\PresentationBundle\Dto\Input\OutputFormat;
use IWD\Symfony\PresentationBundle\Dto\Output\ApiFormatter;
use IWD\Symfony\PresentationBundle\Service\Presenter;
use IWD\Symfony\PresentationBundle\Service\QueryBus\Aggregate\Bus;
use IWD\Symfony\PresentationBundle\Service\QueryBus\Aggregate\Query;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    public const NAME = 'api_admin_app_university_student_read';

    /**
     * @OA\Tag(name="University.Student")
     * @OA\Response(
     *     response=200,
     *     description="Read query for Student",
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
        path: '/api/admin/university/students/{id}.{_format}',
        name: self::NAME,
        defaults: ['_format' => 'json'],
        methods: ['GET'],
    )]
    public function action(
        string $id,
        Bus $bus,
        OutputFormat $outputFormat,
        Presenter $presenter,
    ): Response {
        $query = new Query(
            aggregateId: $id,
            targetEntityClass: Student::class
        );

        /** @var Student $student */
        $student = $bus->query($query);

        return $presenter->present(
            data: ApiFormatter::prepare(
                CommonOutputContract::create($student)
            ),
            outputFormat: $outputFormat
        );
    }
}
