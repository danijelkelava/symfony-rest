<?php

namespace App\Controller\Api\V1\Term;

use App\Entity\Term\Term;
use App\Responder\Responder;
use Nelmio\ApiDocBundle\Annotation\Areas;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class Retrieve
{
    /**
     * @Route(path="/api/v1/term/{name}", methods={"GET"}, name="v1_term_get")
     * @Areas({"default"})
     *
     * @SWG\Get(
     *   tags={"Term"}
     * )
     *
     * @SWG\Parameter(
     *     name="name",
     *     in="path",
     *     type="string",
     *     description="Term name",
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Term",
     *     @Model(type=Term::class, groups={"term:get"})
     * )
     * @param Term $term
     * @param EntityResponder $entityResponder
     * @return JsonResponse
     */
    public function __invoke(Term $term, Responder $responder): JsonResponse
    {
        return $responder($term, 'json', ['term:get'], true);
    }
}