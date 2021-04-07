<?php

namespace App\Controller\Api\V1\Term;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Term\Term;
use App\Manager\TermManager;
use App\Service\GithubAPIService;
use Nelmio\ApiDocBundle\Annotation\Areas;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Retrieve extends BaseController
{

    /**
     * @var TermManager
     */
    private $termManager;

    /**
     * @var GithubAPIService
     */
    private $githubAPIService;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        TermManager $termManager,
        GithubAPIService $githubAPIService
    )
    {
        $this->termManager = $termManager;
        $this->githubAPIService = $githubAPIService;

        parent::__construct($serializer, $validator);
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
     * @return JsonResponse
     */
    public function __invoke(string $name): JsonResponse
    {
        $criteria = ['name' => $name];
        $term = $this->termManager->findTermByCriteria($criteria);

        if (! $term) {
            $json = $this->serializer->serialize($criteria, 'json');
            $term = $this->termManager->createFromJson($json, ['term:create']);            
        }

        // search issues
        $response = $this->githubAPIService->searchIssues($term->getName());

        if (200 !== $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode());
        }
        
        $responseContent = $this->serializer->decode($response->getContent(), 'json');

        // calculate score
        $term = $this->termManager->calculatePopularityScore($term, $responseContent);

        $this->termManager->update($term);

        $result = $this->serializer->serialize($term, 'json', ['groups' => ['term:get']]);

        return new JsonResponse($result, Response::HTTP_OK, [], true);

    }
}