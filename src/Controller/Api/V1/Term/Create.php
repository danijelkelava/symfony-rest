<?php

namespace App\Controller\Api\V1\Term;

use App\Entity\Term\Term;
use App\Factory\EntityFactory;
use App\Repository\Term\TermRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use App\Service\ExtractorService;
use App\Responder\Responder;

class Create 
{

    private $repository;
    private $extractor;
    private $entityFactory;

    public function __construct(
        TermRepository $repository, 
        ExtractorService $extractor, 
        EntityFactory $entityFactory
    )
    {
        $this->repository = $repository;
        $this->extractor = $extractor;
        $this->entityFactory = $entityFactory;
    }

    /**
     * @Route("/api/v1/term/create", methods={"POST"}, name="api_v1_term_create")
     * @SWG\Post(
     *   tags={"Term"}
     * )
     *
     * Add get method so property can be listed inside object
     * @SWG\Parameter(
     *     name="name",
     *     in="body",
     *     description="JSON body",
     *     type="json",
     *     @Model(type=Term::class, groups={"term:create"})
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Term saved",
     *     @Model(type=Term::class, groups={"term:get"})
     * )
     */
    public function __invoke(Request $request, Responder $responder): JsonResponse
    {
        // extract data from request
        //$data = $this->extractor->extractFromJson([], $request->getContent());

        //json string
        $data = $request->getContent();
        
        // create term from data
        $term = $this->entityFactory->createFromJson($data, Term::class, $groups = ['term:create']);
        $term->setScore(5.5);

        // implement term manager
        $this->repository->save($term);

        return $responder($term, 'json', ['term:get'], true);

    }
}
