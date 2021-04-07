<?php

namespace App\Controller\Api\V1\Term;

use App\Controller\BaseController;
use App\Manager\TermManager;
use App\Entity\Term\Term;
use App\Model\CreateTermRequest;
use App\Factory\EntityFactory;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\GithubAPIService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;


class Create extends BaseController
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
        TermManager $manager,
        GithubAPIService $githubAPIService
    )
    {
        $this->termManager = $manager;
        $this->githubAPIService = $githubAPIService;

        parent::__construct($serializer, $validator);
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

        /** @var CreateTermRequest $createTermRequestModel */
        $createTermRequestModel = $this->serializer->deserialize($request->getContent(), CreateTermRequest::class, 'json');

        $errors = $this->validator->validate($createTermRequestModel);

        if ($errors->count() > 0) {
            return new JsonResponse((string)$errors, Response::HTTP_BAD_REQUEST);
        }

        // create array
        $content = $this->serializer->decode($request->getContent(), 'json');

        $term = $this->termManager->findTermByCriteria($content);

        if ($term) {
            throw new BadRequestHttpException("Term exists");
        }
       
        // create term instance from data
        $term = $this->termManager->createFromJson($request->getContent(), ['term:create']);

        $response = $this->githubAPIService->searchIssues($term->getName());

        if (200 !== $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode());
        }
        
        $responseContent = $this->serializer->decode($response->getContent(), 'json');

        $term = $this->termManager->calculatePopularityScore($term, $responseContent);

        $this->termManager->save($term);

        $result = $this->serializer->serialize($term, 'json', ['groups' => ['term:get']]);

        return new JsonResponse($result, Response::HTTP_OK, [], true);

    }
}
