<?php

namespace App\Controller\Api\V1\Term;

use App\Controller\BaseController;
use App\Entity\Term\Term;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Manager\TermManager;
use App\Manager\SearchManager;
use Nelmio\ApiDocBundle\Annotation\Areas;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
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
     * @var SearchManager
     */
    private $searchManager;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        TermManager $termManager,
        SearchManager $searchManager
    )
    {
        $this->termManager = $termManager;
        $this->searchManager = $searchManager;

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
     * @throws BadRequestHttpException
     * @throws HttpException
     */
    public function __invoke(string $name): JsonResponse
    {
        
        if (! $name) {
            throw new BadRequestHttpException('Name is required');           
        }

        $term = $this->termManager->findTermByCriteria(['name' => $name]);

        if (! $term) {
            $json = $this->serializer->serialize(['name' => $name], 'json');

            // create term from json
            $term = $this->termManager->createFromJson($json, ['term:create']);   

            // search issues
            $response = $this->searchManager->searchTerm($term->getName());

            if (200 !== $response->getStatusCode()) {
                throw new HttpException($response->getStatusCode());
            }
            
            $responseContent = $this->serializer->decode($response->getContent(), 'json');

            $term->setTotalCount((int)$responseContent['total_count']);

            // set score
            $term = $this->termManager->setScore($term);   

            $this->termManager->save($term);    

        }else{

            $term = $this->termManager->setScore($term);

        }        

        $result = $this->serializer->serialize($term, 'json', ['groups' => ['term:get']]);

        return new JsonResponse($result, Response::HTTP_OK, [], true);

    }
}