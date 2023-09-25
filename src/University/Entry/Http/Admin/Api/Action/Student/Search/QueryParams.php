<?php

declare(strict_types=1);

namespace App\University\Entry\Http\Admin\Api\Action\Student\Search;

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
     *         "id": {"eq": "46841"},
     *         "createdAt": {"range": "1972-10-29 16:29:01,1972-11-13 16:29:01"},
     *         "updatedAt": {"range": "2009-01-13 04:15:48,2009-01-27 04:15:48"},
     *         "birthDay": {"range": "1972-10-16 10:57:00,1972-11-11 10:57:00"},
     *         "firstName": {"eq": "bar"},
     *         "lastName": {"like": "osе"},
     *         "middleName": {"eq": "bar"},
     *         "university.id": {"eq": "60947"},
     *         "university.createdAt": {"range": "2015-07-26 20:26:50,2015-08-12 20:26:50"},
     *         "university.updatedAt": {"range": "1977-06-08 07:35:27,1977-06-11 07:35:27"},
     *         "university.description": {"like": "thud"},
     *         "university.maxStudents": {"range": "52,191"},
     *         "university.name": {"like": "thud"}
     *     }
     * )
     */
    public Filters $filters;
}
