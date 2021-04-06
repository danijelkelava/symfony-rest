<?php

namespace App\Controller\Api\V1\Term;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Term\Term;
use App\Repository\Term\TermRepository;
use App\Responder\Responder;
use Nelmio\ApiDocBundle\Annotation\Areas;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Retrieve extends BaseController
{

    private $repository;

    public function __construct(
        SerializerInterface $serializer,
        TermRepository $repository
    )
    {
        $this->repository = $repository;
        parent::__construct($serializer);
    }
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
     *
     * @param string $name
     * @param Responder $responder
     * @return JsonResponse
     */
    public function __invoke(string $name, Responder $responder): JsonResponse
    {

        $term = $this->repository->findOneBy(['name' => $name]);

        if (! $term) {
            throw new BadRequestHttpException("Term with name $name not found");
        }


        return $responder($term, 'json', ['term:get'], true);
    }
}