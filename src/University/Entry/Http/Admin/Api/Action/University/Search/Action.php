<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\University\Search;

use App\University\Domain\University\University;
use App\University\Entry\Http\Admin\Api\Contract\University\CommonOutputContract;
use IWD\Symfony\PresentationBundle\Dto\Input\OutputFormat;
use IWD\Symfony\PresentationBundle\Dto\Input\SearchQuery;
use IWD\Symfony\PresentationBundle\Dto\Output\ApiFormatter;
use IWD\Symfony\PresentationBundle\Dto\Output\OutputPagination;
use IWD\Symfony\PresentationBundle\Service\Presenter;
use IWD\Symfony\PresentationBundle\Service\QueryBus\Search\Bus;
use IWD\Symfony\PresentationBundle\Service\QueryBus\Search\Query;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Action
{
    public const NAME = 'api_admin_app_university_university_search';

    /**
     * @OA\Tag(name="University.University")
     * @OA\Get(
     *     @OA\Parameter(
     *          name="searchQuery",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              ref=@Model(type=QueryParams::class)
     *          ),
     *     )
     * )
     * @OA\Response(
     *     response=200,
     *     description="Search query for University",
     *     @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref=@Model(type=ApiFormatter::class)),
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="data",
     *                      type="object",
     *                      @OA\Property(
     *                          property="data",
     *                          ref=@Model(type=CommonOutputContract::class),
     *                          type="object"
     *                      ),
     *                      @OA\Property(
     *                          property="pagination",
     *                          ref=@Model(type=OutputPagination::class),
     *                          type="object"
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="status",
     *                      example="200"
     *                 )
     *             )
     *         }
     *     )
     * )
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
        path: '/api/admin/university/universities.{_format}',
        name: self::NAME,
        defaults: ['_format' => 'json'],
        methods: ['GET'],
    )]
    public function action(
        SearchQuery $searchQuery,
        Bus $bus,
        OutputFormat $outputFormat,
        Presenter $presenter,
    ): Response {
        $query = new Query(
            targetEntityClass: University::class,
            pagination: $searchQuery->pagination,
            filters: $searchQuery->filters,
            sorts: $searchQuery->sorts
        );

        $searchResult = $bus->query($query);

        return $presenter->present(
            data: ApiFormatter::prepare([
                'data' => array_map(static function (University $university) {
                    return CommonOutputContract::create($university);
                }, $searchResult->entities),
                'pagination' => $searchResult->pagination,
            ]),
            outputFormat: $outputFormat
        );
    }
}
