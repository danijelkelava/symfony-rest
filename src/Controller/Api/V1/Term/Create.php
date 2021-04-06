<?php

namespace App\Controller\Api\V1\Term;

use App\Entity\Term\Term;
use App\Factory\EntityFactory;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\Term\TermRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use App\Service\GithubAPIService;
use App\Service\ExtractorService;


class Create 
{

    private $serializer;
    private $repository;
    private $extractor;
    private $entityFactory;
    private $githubAPIService;

    public function __construct(
        SerializerInterface $serializer,
        TermRepository $repository, 
        ExtractorService $extractor, 
        EntityFactory $entityFactory,
        GithubAPIService $githubAPIService
    )
    {
        $this->serializer = $serializer;
        $this->repository = $repository;
        $this->extractor = $extractor;
        $this->entityFactory = $entityFactory;
        $this->githubAPIService = $githubAPIService;
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
    public function __invoke(Request $request): JsonResponse
    {
        // extract data from request
        //$data = $this->extractor->extractFromJson([], $request->getContent());

        //json string
        $data = $request->getContent();
        
        // create term instance from data
        $term = $this->entityFactory->createFromJson($data, Term::class, $groups = ['term:create']);

        // implement term manager
        $response = $this->githubAPIService->searchIssues('Kelava');

        //$content = json_decode($response->getContent(), true);
        $content = $this->serializer->decode($response->getContent(), 'json');

        $term->setTotalCount($content['total_count']);
        $term->setScore(5.5);

        $this->repository->save($term);

        $result = $this->serializer->serialize($term, 'json', ['groups' => ['term:get']]);

        return new JsonResponse($result, Response::HTTP_OK, [], true);

    }
}
