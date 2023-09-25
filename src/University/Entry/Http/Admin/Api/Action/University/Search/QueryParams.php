<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\University\Search;

use IWD\Symfony\PresentationBundle\Dto\Input\Filters;
use IWD\Symfony\PresentationBundle\Dto\Input\SearchQuery;
use OpenApi\Annotations as OA;

/** @codeCoverageIgnore */
class QueryParams extends SearchQuery
{
    /**
     * @OA\Property(
     *     property="filter",
     *     type="object",
     *     example={
     *         "id": {"eq": "16066"},
     *         "createdAt": {"range": "2002-03-29 07:44:06,2002-04-20 07:44:06"},
     *         "updatedAt": {"range": "1983-08-21 08:21:15,1983-08-25 08:21:15"},
     *         "description": {"like": "qux"},
     *         "maxStudents": {"range": "13,763"},
     *         "name": {"eq": "bar"},
     *         "university.id": {"eq": "38745"},
     *         "university.createdAt": {"range": "2006-04-03 06:37:17,2006-04-23 06:37:17"},
     *         "university.updatedAt": {"range": "1973-03-10 03:03:20,1973-03-14 03:03:20"},
     *         "university.birthDay": {"range": "2030-12-01 18:42:35,2030-12-28 18:42:35"},
     *         "university.firstName": {"like": "bar"},
     *         "university.lastName": {"eq": "qux"},
     *         "university.middleName": {"like": "rol"}
     *     }
     * )
     */
    public Filters $filters;
}
